<?php

namespace App\Components\CSVDataLoader;

use App\Models\Operation;
use App\Models\TechnicalSystem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OperationLoader
{
    const FILE_NAME = 'operations.csv';

    /**
     * Add new operation to database.
     *
     * @param array $row - row with data
     * @param int $document_id - id target document
     * @param bool $encoding - flag to include or exclude encoding conversion from windows-1251 to utf-8
     */
    public function addOperation(array $row, int $document_id, bool $encoding = false)
    {
        list($name, $operation_code, $section, $subsection, $system_code, $start_page, $end_page, $actual_page) = $row;
        // Создание новой работы (операции) в БД
        $operation_id = DB::table('operation')->insertGetId([
            'code' => $encoding ? mb_convert_encoding($operation_code, 'utf-8', 'windows-1251') : $operation_code,
            'type' => Operation::BASIC_OPERATION_TYPE,
            'imperative_name' => null,
            'verbal_name' => $encoding ? mb_convert_encoding($name, 'utf-8', 'windows-1251') : $name,
            'description' => null,
            'document_section' => $section,
            'document_subsection' => $subsection,
            'start_document_page' => $start_page != '' ? $start_page : null,
            'end_document_page' => $end_page != '' ? $end_page : null,
            'actual_document_page' => $actual_page != '' ? $actual_page : null,
            'document_id' => $document_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // Создание новой связи работы (операции) с техническими системами в БД
        if ($system_code != '')
            foreach (TechnicalSystem::where('code', $system_code)->get() as $technical_system)
                DB::table('technical_system_operation')->insert([
                    'operation_id' => $operation_id,
                    'technical_system_id' => $technical_system->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
    }

    /**
     * Get source data on operations and store this data in database.
     *
     * @param int $document_id - id target document
     * @param bool $encoding - flag to include or exclude encoding conversion from windows-1251 to utf-8
     */
    public function createOperations(int $document_id, bool $encoding = false)
    {
        // Пусть к csv-файлу с работами (операциями)
        $file = resource_path() . '/csv/' . self::FILE_NAME;
        // Открываем файл с CSV-данными
        $fh = fopen($file, 'r');
        // Делаем пропуск первой строки, смещая указатель на одну строку
        fgetcsv($fh, 0, ',');
        // Читаем построчно содержимое CSV-файла
        while (($row = fgetcsv($fh, 0, ',')) !== false)
            // Игнорирование пустых строк и строк начинающихся с комментария
            if (array(null) !== $row and array_filter($row) and strncmp($row[0], '/*', 2) !== 0)
                self::addOperation($row, $document_id, $encoding);
    }
}
