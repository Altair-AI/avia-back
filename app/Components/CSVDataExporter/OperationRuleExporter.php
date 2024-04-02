<?php

namespace App\Components\CSVDataExporter;

use App\Models\Operation;
use App\Models\OperationResult;
use App\Models\OperationRule;

class OperationRuleExporter extends CSVFileExporter
{
    const FILE_NAME = 'operation_rules_export.csv';
    const CSV_FILE_HEADER = [
        'Тип правила',
        'Контекст работы',
        'Приоритет',
        'Код работы (условие)',
        'Наименование работы (условие)',
        'Статус работы (условие)',
        'Результат работы (условие)',
        'Код работы (действие)',
        'Наименование работы (действие)',
        'Статус работы (действие)',
        'Результат работы (действие)',
        'Флаг повтора озвучивания',
        'id отказавшей системы или объекта',
        'id причины отказа',
        'id документа'
    ];

    /**
     * Get data array for one record with operation rule.
     *
     * @param OperationRule $operation_rule
     * @return array
     */
    public function getRow(OperationRule $operation_rule)
    {
        $row = [];
        array_push($row, $operation_rule->type);
        array_push($row, $operation_rule->context);
        array_push($row, $operation_rule->priority);

        $operation_if = Operation::whereId($operation_rule->operation_id_if)->first();
        array_push($row, $operation_if->code);
        $name = $operation_if->verbal_name != '' ? $operation_if->verbal_name : $operation_if->imperative_name;
        array_push($row, $name);
        array_push($row, $operation_rule->operation_status_if);
        $operation_result = OperationResult::whereId($operation_rule->operation_result_id_if)->first();
        array_push($row, $operation_result != null ? $operation_result->name : '');

        $operation_then = Operation::whereId($operation_rule->operation_id_then)->first();
        array_push($row, $operation_then->code);
        $name = $operation_then->verbal_name != '' ? $operation_then->verbal_name : $operation_then->imperative_name;
        array_push($row, $name);
        array_push($row, $operation_rule->operation_status_then);
        $operation_result = OperationResult::whereId($operation_rule->operation_result_id_then)->first();
        array_push($row, $operation_result != null ? $operation_result->name : '');

        array_push($row, $operation_rule->repeat_voice);
        array_push($row, $operation_rule->malfunction_system_id);
        array_push($row, $operation_rule->malfunction_cause_id);
        array_push($row, $operation_rule->document_id);

        return $row;
    }

    /**
     * Generate data array based on database records with operation rules.
     *
     * @param $operation_rules
     * @return array
     */
    public function generate($operation_rules)
    {
        $data = [];
        array_push($data, self::CSV_FILE_HEADER);
        foreach ($operation_rules as $operation_rule)
            array_push($data, self::getRow($operation_rule));
        return $data;
    }
}
