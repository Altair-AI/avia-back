<?php

namespace App\Components\CSVDataExporter;

use App\Models\ConcreteOperationCondition;
use App\Models\ConcreteOperationResult;
use App\Models\MalfunctionCause;
use App\Models\MalfunctionCauseOperation;
use App\Models\OperationCondition;
use App\Models\OperationHierarchy;
use App\Models\OperationResult;

class SubOperationExporter extends CSVFileExporter
{
    const FILE_NAME = 'suboperations_export.csv';
    const CSV_FILE_HEADER = [
        'Номер работы',
        'Обозначение в документации',
        'Содержание работы в повелительном наклонении',
        'Номер работы, куда входит текущая работа',
        'Название работы',
        'Порядок работ',
        'Результат',
        'Условие выполнения',
        'Причины'
    ];

    /**
     * Get data array for one record with parent and child operation.
     *
     * @param OperationHierarchy $operation
     * @return array
     */
    public function getRow(OperationHierarchy $operation)
    {
        $row = [];
        array_push($row, $operation->child_operation->code);
        array_push($row, $operation->designation);
        array_push($row, $operation->child_operation->imperative_name);
        array_push($row, $operation->parent_operation->code);

        $operation_name = $operation->parent_operation->verbal_name != '' ? $operation->parent_operation->verbal_name :
            $operation->parent_operation->imperative_name;
        array_push($row, $operation_name);

        array_push($row, $operation->sequence_number);

        $results = OperationResult::whereIn('id', ConcreteOperationResult::select(['operation_result_id'])
            ->where('operation_id', $operation->child_operation_id))
            ->get();
        $operation_results = '';
        foreach ($results as $result)
            if ($operation_results === '')
                $operation_results = $result->name;
            else
                $operation_results .= ' / ' . $result->name;
        array_push($row, $operation_results);

        $cons = OperationCondition::whereIn('id', ConcreteOperationCondition::select(['operation_condition_id'])
            ->where('operation_id', $operation->child_operation_id))
            ->get();
        $operation_conditions = '';
        foreach ($cons as $condition)
            if ($operation_conditions === '')
                $operation_conditions = $condition->name;
            else
                $operation_conditions .= ' / ' . $condition->name;
        array_push($row, $operation_conditions);

        $m_causes = MalfunctionCause::whereIn('id', MalfunctionCauseOperation::select(['malfunction_cause_id'])
            ->where('operation_id', $operation->child_operation_id))
            ->get();
        $operation_malfunction_causes = '';
        foreach ($m_causes as $malfunction_cause)
            if ($operation_malfunction_causes === '')
                $operation_malfunction_causes = $malfunction_cause->name;
            else
                $operation_malfunction_causes .= ' / ' . $malfunction_cause->name;
        array_push($row, $operation_malfunction_causes);

        return $row;
    }

    /**
     * Generate data array based on database records with child operations.
     *
     * @param $operations
     * @return array
     */
    public function generate($operations)
    {
        $data = [];
        array_push($data, self::CSV_FILE_HEADER);
        foreach ($operations as $operation) {
            // Получение всех родительских работ для текущей работы
            $parent_operations = OperationHierarchy::where('child_operation_id', $operation->id)->get();
            // Создание записи для каждой родительской работы
            foreach ($parent_operations as $parent_operation)
                array_push($data, self::getRow($parent_operation));
        }
        return $data;
    }
}
