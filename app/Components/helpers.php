<?php

namespace App\Components;

use App\Models\Organization;
use App\Models\TechnicalSystem;


/**
 * Формирование вложенного массива (иерархии) технических систем, которые доступны организации
 * в рамках определенной лицензии и проекта.
 *
 * @param $organization_id - id организации
 * @return array
 */
function get_technical_system_hierarchy($organization_id)
{
    $technical_systems = [];
    foreach (Organization::find($organization_id)->licenses as $license) {
        $model = $license->project->technical_system->toArray();
        $model['grandchildren_technical_systems'] = TechnicalSystem::find(
            $license->project->technical_system_id)->grandchildren_technical_systems;
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
function get_technical_system_ids($technical_systems, $id_list)
{
    foreach ($technical_systems as $item) {
        array_push($id_list, $item['id']);
        if (!empty($item['grandchildren_technical_systems']))
            $id_list = get_technical_system_ids($item['grandchildren_technical_systems'], $id_list);
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
function get_technical_system_codes($technical_systems, $code_list)
{
    foreach ($technical_systems as $item) {
        array_push($id_list, $item['code']);
        if (!empty($item['grandchildren_technical_systems']))
            $code_list = get_technical_system_codes($item['grandchildren_technical_systems'], $code_list);
    }
    return $code_list;
}
