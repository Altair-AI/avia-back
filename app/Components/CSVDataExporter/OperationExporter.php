<?php

namespace App\Components\CSVDataExporter;

use App\Models\Operation;
use App\Models\TechnicalSystemOperation;

class OperationExporter extends CSVFileExporter
{
    const FILE_NAME = 'operations_export.csv';
    const CSV_FILE_HEADER = [
        'Имя',
        'Номер работы',
        'Раздел',
        'Подраздел',
        'Код системы',
        'Номер страницы начальной',
        'Номер страницы конечной',
        'Номер фактической страницы'
    ];

    /**
     * Get data array for one record with main operation.
     *
     * @param Operation $operation
     * @return array
     */
    public function getRow(Operation $operation)
    {
        $row = [];
        $operation_name = $operation->verbal_name != '' ? $operation->verbal_name : $operation->imperative_name;
        array_push($row, $operation_name);

        array_push($row, $operation->code);
        array_push($row, $operation->document_section);
        array_push($row, $operation->document_subsection);

        $tech_sys_operation = TechnicalSystemOperation::where('operation_id', $operation->id)->first();
        array_push($row, $tech_sys_operation ? $tech_sys_operation->technical_system->code : null);

        array_push($row, $operation->start_document_page);
        array_push($row, $operation->end_document_page);
        array_push($row, $operation->actual_document_page);

        return $row;
    }

    /**
     * Generate data array based on database records with main operations.
     *
     * @param $operations
     * @return array
     */
    public function generate($operations)
    {
        $data = [];
        array_push($data, self::CSV_FILE_HEADER);
        foreach ($operations as $operation)
            array_push($data, self::getRow($operation));
        return $data;
    }
}
