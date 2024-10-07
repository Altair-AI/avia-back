<?php

namespace App\Components;

use App\Http\Resources\Operation\SubOperationResource;
use App\Http\Resources\OperationResult\OperationResultResource;
use App\Models\CompletedOperation;
use App\Models\Operation;
use App\Models\OperationHierarchy;
use App\Models\Organization;
use App\Models\TechnicalSystem;


class Helper
{
    /**
     * Формирование вложенного массива (иерархии) технических систем, которые доступны организации
     * в рамках определенной лицензии и проекта.
     *
     * @param $organization_id - id организации
     * @return array
     */
    public static function get_technical_system_hierarchy($organization_id)
    {
        $technical_systems = [];
        foreach (Organization::find($organization_id)->licenses as $license) {
            $model = $license->project->technical_system->toArray();
            $model['technical_subsystems'] = TechnicalSystem::find(
                $license->project->technical_system_id)->technical_subsystems;
            array_push($technical_systems, $model);
        }
        return $technical_systems;
    }


    /**
     * Получение списка id для всех дочерних технических систем или объектов (если они есть).
     *
     * @param $technical_systems - массив сериализованных объектов технических систем
     * @param $id_list - массив id технических систем
     * @return mixed
     */
    public static function get_technical_system_ids($technical_systems, $id_list)
    {
        foreach ($technical_systems as $item) {
            array_push($id_list, $item['id']);
            if (!empty($item['technical_subsystems']))
                $id_list = self::get_technical_system_ids($item['technical_subsystems'], $id_list);
        }
        return $id_list;
    }


    /**
     * Получение списка id для всех дочерних технических систем или объектов (если они есть).
     *
     * @param $technical_systems - массив сериализованных объектов технических систем
     * @param $code_list - массив кодов технических систем
     * @return mixed
     */
    public static function get_technical_system_codes($technical_systems, $code_list)
    {
        foreach ($technical_systems as $item) {
            array_push($code_list, $item['code']);
            if (!empty($item['technical_subsystems']))
                $code_list = self::get_technical_system_codes($item['technical_subsystems'], $code_list);
        }
        return $code_list;
    }

    /**
     * Обновление узла работы в дереве выполненных работ (операций).
     *
     * @param $operations - массив выполненных работ в виде дерева
     * @param $completed_operation - выполненная работа из БД
     * @param $exist - флаг существования узла работы в дереве работ (операций)
     * @return array
     */
    public static function find_node($operations, $completed_operation, $exist) {
        foreach ($operations as & $operation)
            if ($operation['id'] == $completed_operation->operation_id and !$exist and
                $operation['status'] != CompletedOperation::COMPLETED_OPERATION_STATUS) {
                $operation['status'] = $completed_operation->operation_status;
                $operation['result'] = $completed_operation->operation_result_id ?
                    new OperationResultResource($completed_operation->operation_result) : null;
                $exist = true;
            } else
                list($operation['sub_operations'], $exist) = self::find_node($operation['sub_operations'],
                    $completed_operation, $exist);
        return array($operations, $exist);
    }

    /**
     * Создание нового узла работы в дереве выполненных работ (операций).
     *
     * @param $operations - массив выполненных работ в виде дерева
     * @param $completed_operation - выполненная работа из БД
     * @param $parents - массив родительских работ для текущей выполненной работы
     * @param $created - флаг создания нового узла работы в дереве работ (операций)
     * @return array
     */
    public static function create_node($operations, $completed_operation, $parents, $created) {
        foreach ($parents as $parent)
            foreach ($operations as & $operation)
                if ($operation['id'] == $parent->parent_operation_id and !$created and
                    $operation['status'] != CompletedOperation::COMPLETED_OPERATION_STATUS) {
                    $resource = SubOperationResource::make(Operation::find($completed_operation->operation_id))
                        ->resolve();
                    $resource['status'] = $completed_operation->operation_status;
                    $resource['result'] = $completed_operation->operation_result_id ?
                        new OperationResultResource($completed_operation->operation_result) : null;
                    array_push($operation['sub_operations'], $resource);
                    $created = true;
                } else
                    list($operation['sub_operations'], $created) = self::create_node($operation['sub_operations'],
                        $completed_operation, $parents, $created);
        return array($operations, $created);
    }

    /**
     * Создание дерева выполненных работ (операций) для текущей рабочей сессии.
     *
     * @param $work_session_id - id рабочей сессии
     * @return array|mixed
     */
    public static function create_operation_tree($work_session_id) {
        // Формирование корневого узла начальной работы РУН для дерева выполненных работ
        $completed_parent_operation = CompletedOperation::where('work_session_id', $work_session_id)
            ->where('previous_operation_id', null)
            ->first();
        $parent_operation = SubOperationResource::make(Operation::find($completed_parent_operation->operation_id))
            ->resolve();
        $parent_operation['status'] = $completed_parent_operation->operation_status;
        $parent_operation['result'] = $completed_parent_operation->operation_result_id ?
            new OperationResultResource($completed_parent_operation->operation_result) : null;
        $data = [$parent_operation];
        // Поиск всех выполненных работ в БД, кроме начальной работы РУН
        $completed_operations = CompletedOperation::where('work_session_id', $work_session_id)->get();
        // Формирование списка id всех выполненных работ (данные id будут выступать в роли id родительских работ)
        $parent_ids = [];
        foreach ($completed_operations as $completed_operation)
            if (!in_array($completed_operation->operation_id, $parent_ids))
                array_push($parent_ids, $completed_operation->operation_id);
        // Обход всех найденных выполненных работ
        foreach ($completed_operations as $completed_operation) {
            // Поиск и обновление узла выполненной работы в дереве работ
            list($data, $exist) = self::find_node($data, $completed_operation, false);
            // Создание нового узла работы в дереве работ
            if (!$exist) {
                $parents = OperationHierarchy::where('child_operation_id', $completed_operation->operation_id)
                    ->whereIn('parent_operation_id', $parent_ids)
                    ->get();
                list($data, $created) = self::create_node($data, $completed_operation, $parents, false);
            }
        }
        return $data;
    }

    /**
     * Возвращает IP-адрес клиента.
     *
     * @return string
     */
    public static function getIp() {
        $keys = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'REMOTE_ADDR'
        ];
        foreach ($keys as $key)
            if (!empty($_SERVER[$key])) {
                $array = explode(',', $_SERVER[$key]);
                $ip = trim(end($array));
                if (filter_var($ip, FILTER_VALIDATE_IP))
                    return $ip;
            }
        return '';
    }
}
