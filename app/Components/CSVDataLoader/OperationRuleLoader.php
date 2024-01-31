<?php

namespace App\Components\CSVDataLoader;

use App\Models\MalfunctionCause;
use App\Models\Operation;
use App\Models\OperationResult;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OperationRuleLoader
{
    const FILE_NAME = 'operation_rules.csv';

    /**
     * Get operation result id.
     *
     * @param String $operation_result_name - name of operation result from rule condition or action
     * @return int|mixed|null
     */
    public function get_operation_result_id(string $operation_result_name)
    {
        $operation_result_id = null;
        if ($operation_result_name != "") {
            // Поиск результата работы по названию
            $operation_result_model = OperationResult::where('name', $operation_result_name)->first();
            // Создание нового результата работы, если его нет в БД
            if ($operation_result_model)
                $operation_result_id = $operation_result_model->id;
            else
                $operation_result_id = DB::table('operation_result')->insertGetId([
                    'name' => $operation_result_name != "" ? $operation_result_name : null,
                    'description' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        }
        return $operation_result_id;
    }

    /**
     * Get source data on operation rules and store this data in database.
     *
     * @param int $knowledge_base_id - id target rule based knowledge base
     * @param bool $encoding - flag to include or exclude encoding conversion from windows-1251 to utf-8
     * @return array|false|string|string[]|null
     */
    public function create_operation_rules(int $knowledge_base_id, bool $encoding = false)
    {
        $operation_rules = [];
        // Пусть к csv-файлу с правилами последовательностей работ
        $file = resource_path() . '/csv/' . self::FILE_NAME;
        // Открываем файл с CSV-данными
        $fh = fopen($file, "r");
        // Делаем пропуск первой строки, смещая указатель на одну строку
        fgetcsv($fh, 0, ';');

        // Читаем построчно содержимое CSV-файла
        while (($row = fgetcsv($fh, 0, ';')) !== false) {
            list($type_rule, $context, $priority, $operation_code_if, $operation_name_if, $operation_status_if,
                $operation_result_if, $operation_code_then, $operation_name_then, $operation_status_then,
                $operation_result_then, $repeat_voice, $malfunction_system, $malfunction_cause, $document_id) = $row;
            array_push($operation_rules, [$type_rule, $context, $priority, $operation_code_if, $operation_name_if,
                $operation_status_if, $operation_result_if, $operation_code_then, $operation_name_then,
                $operation_status_then, $operation_result_then, $repeat_voice, $malfunction_system, $malfunction_cause,
                $document_id]);

            // Поиск работы (условие) по коду
            $operation_if = Operation::where('code', $operation_code_if)->first();
            // Поиск работы (действие) по коду
            $operation_then = Operation::where('code', $operation_code_then)->first();

            // Если работы найдены
            if ($operation_if and $operation_then) {
                // Формирование корректных названий
                $context_name = $context;
                $operation_result_name_if = $operation_result_if;
                $operation_result_name_then = $operation_result_then;
                $malfunction_cause_name = $malfunction_cause;
                if ($encoding) {
                    $context_name = mb_convert_encoding($context, 'utf-8', 'windows-1251');
                    $operation_result_name_if = mb_convert_encoding($operation_result_if, 'utf-8', 'windows-1251');
                    $operation_result_name_then = mb_convert_encoding($operation_result_then, 'utf-8', 'windows-1251');
                    $malfunction_cause_name = mb_convert_encoding($malfunction_cause, 'utf-8', 'windows-1251');
                }

                // Получение id результата работы из условия и действия
                $operation_result_id_if = self::get_operation_result_id($operation_result_name_if);
                $operation_result_id_then = self::get_operation_result_id($operation_result_name_then);

                $malfunction_cause_id = null;
                if ($malfunction_cause_name != "") {
                    // Поиск причины неисправности по названию
                    $malfunction_cause_model = MalfunctionCause::where('name', $malfunction_cause_name)->first();
                    if ($malfunction_cause_model)
                        $malfunction_cause_id = $malfunction_cause_model->id;
                }

                // Поиск технической системы связанной с работой (условием)
                $technical_system_id = null;
                $technical_system = $operation_if->technical_systems->first();
                if ($technical_system)
                    $technical_system_id = $technical_system->id;

                // Создание нового правила для базы знаний правил в БД
                DB::table('operation_rule')->insert([
                    'description' => null,
                    'rule_based_knowledge_base_id' => $knowledge_base_id,
                    'type' => (int)$type_rule,
                    'operation_id_if' => $operation_if->id,
                    'operation_status_if' => (int)$operation_status_if,
                    'operation_result_id_if' => $operation_result_id_if,
                    'operation_id_then' => $operation_then->id,
                    'operation_status_then' => (int)$operation_status_then,
                    'operation_result_id_then' => $operation_result_id_then,
                    'priority' => $priority != "" ? (int)$priority : 0,
                    'repeat_voice' => (int)$repeat_voice,
                    'context' => $context_name != "" ? $context_name : null,
                    'malfunction_cause_id' => $malfunction_cause_id,
                    'malfunction_system_id' => $technical_system_id,
                    'document_id' => $operation_if->document_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        return $encoding ? mb_convert_encoding($operation_rules, 'utf-8', 'windows-1251') : $operation_rules;
    }
}
