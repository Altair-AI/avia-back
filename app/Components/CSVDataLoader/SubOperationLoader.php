<?php

namespace App\Components\CSVDataLoader;

use App\Models\ConcreteOperationCondition;
use App\Models\ConcreteOperationResult;
use App\Models\MalfunctionCause;
use App\Models\MalfunctionCauseOperation;
use App\Models\Operation;
use App\Models\OperationCondition;
use App\Models\OperationResult;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SubOperationLoader
{
    const FILE_NAME = 'suboperations.csv';

    /**
     * Get normalized operation code.
     *
     * @param string $code
     * @return string|string[]
     */
    public function normalizeOperationCode(string $code)
    {
        $cyr = ['А', 'В', 'Е'];
        $lat = ['A', 'B', 'E'];
        return str_replace($lat, $cyr, $code);
    }

    /**
     * Create new operation results in database.
     *
     * @param string $result - operation results in the form of source string
     * @param int $operation_id - id operation
     */
    public function createOperationResults(string $result, int $operation_id)
    {
        // Получение строковых значений с результатами
        $result_names = explode(' / ', $result);
        // Обход результатов
        foreach ($result_names as $result_name) {
            // Поиск результата работы (операции)
            $operation_result = OperationResult::where('name', $result_name)->first();
            if ($operation_result)
                $operation_result_id = $operation_result->id;
            else
                // Создание нового результата работы (операции) в БД
                $operation_result_id = DB::table('operation_result')->insertGetId([
                    'name' => $result_name,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            // Поиск связи результата работы (операции) с конкретной работой (операцией)
            $concrete_operation_results = ConcreteOperationResult::where('operation_id', $operation_id)
                ->where('operation_result_id', $operation_result_id)
                ->first();
            // Создание новой связи результата работы (операции) с конкретной работой (операцией) в БД, если ее нет
            if (!$concrete_operation_results)
                DB::table('concrete_operation_result')->insert([
                    'operation_id' => $operation_id,
                    'operation_result_id' => $operation_result_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        }
    }

    /**
     * Create new operation conditions in database.
     *
     * @param string $condition - operation condition in the form of source string
     * @param int $operation_id - id operation
     */
    public function createOperationConditions(string $condition, int $operation_id)
    {
        // Поиск условия работы (операции)
        $operation_condition = OperationCondition::where('name', $condition)->first();
        if ($operation_condition)
            $operation_condition_id = $operation_condition->id;
        else
            // Создание нового условия работы (операции) в БД
            $operation_condition_id = DB::table('operation_condition')->insertGetId([
                'name' => $condition,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        // Поиск связи условия работы (операции) с конкретной работой (операцией)
        $concrete_operation_conditions = ConcreteOperationCondition::where('operation_id', $operation_id)
            ->where('operation_condition_id', $operation_condition_id)
            ->first();
        // Создание новой связи условия работы (операции) с конкретной работой (операцией) в БД, если ее нет
        if (!$concrete_operation_conditions)
            DB::table('concrete_operation_condition')->insert([
                'operation_id' => $operation_id,
                'operation_condition_id' => $operation_condition_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
    }

    /**
     * Create new malfunction causes for operations in database.
     *
     * @param string $cause - malfunction cause in the form of source string
     * @param int $parent_operation_id - id parent operation
     * @param int $child_operation_id - id child operation
     */
    public function createOperationMalfunctionCauses(string $cause, int $parent_operation_id, int $child_operation_id)
    {
        // Поиск причины неисправности
        $malfunction_cause = MalfunctionCause::where('name', $cause)->first();
        if ($malfunction_cause)
            $malfunction_cause_id = $malfunction_cause->id;
        else
            // Создание новой причины неисправности в БД
            $malfunction_cause_id = DB::table('malfunction_cause')->insertGetId([
                'name' => $cause,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        // Создание новой связи причины неисправности с родительской работой (операцией) в БД (если ее там нет)
        $parent_operation_mc = MalfunctionCauseOperation::where('operation_id', $parent_operation_id)
            ->where('malfunction_cause_id', $malfunction_cause_id)
            ->first();
        if (!$parent_operation_mc) {
            $mco_count = MalfunctionCauseOperation::where('operation_id', $parent_operation_id)->count();
            DB::table('malfunction_cause_operation')->insert([
                'source_priority' => 100 - ($mco_count * 10),
                'case_priority' => null,
                'operation_id' => $parent_operation_id,
                'malfunction_cause_id' => $malfunction_cause_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // Создание новой связи причины неисправности с дочерней работой (операцией) в БД (если ее там нет)
        $child_operation_mc = MalfunctionCauseOperation::where('operation_id', $child_operation_id)
            ->where('malfunction_cause_id', $malfunction_cause_id)
            ->first();
        if (!$child_operation_mc) {
            $mco_count = MalfunctionCauseOperation::where('operation_id', $parent_operation_id)->count();
            DB::table('malfunction_cause_operation')->insert([
                'source_priority' => 100 - ($mco_count * 10),
                'case_priority' => null,
                'operation_id' => $child_operation_id,
                'malfunction_cause_id' => $malfunction_cause_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    /**
     * Add new sub-operation to database.
     *
     * @param array $row - row with data
     * @param bool $encoding - flag to include or exclude encoding conversion from windows-1251 to utf-8
     */
    public function addSubOperation(array $row, bool $encoding = false)
    {
        error_reporting(0); // TODO: fix me
        list($child_operation_code, $designation, $imperative_name, $parent_operation_code, $verbal_name,
            $sequence_number, $result, $condition, $cause) = $row;
        if ($child_operation_code != '' and $parent_operation_code != '') {
            $operation_id = null;
            // Поиск родительской работы по коду
            $parent_operation = Operation::where('code', self::normalizeOperationCode($parent_operation_code))
                ->first();
            // Поиск дочерней работы по коду
            $child_operation = Operation::where('code', $child_operation_code)->first();
            // Если родительская работа с таким кодом есть в БД, а дочерней работы нет
            if ($parent_operation and !$child_operation) {
                $code = $encoding ? mb_convert_encoding($child_operation_code, 'utf-8', 'windows-1251') :
                    $child_operation_code;
                // Создание новой подработы (подоперации) в БД
                $operation_id = DB::table('operation')->insertGetId([
                    'code' => self::normalizeOperationCode($code),
                    'type' => Operation::NESTED_OPERATION_TYPE,
                    'imperative_name' => $encoding ? mb_convert_encoding($imperative_name, 'utf-8', 'windows-1251') :
                        $imperative_name,
                    'verbal_name' => $encoding ? mb_convert_encoding($verbal_name, 'utf-8', 'windows-1251') :
                        $verbal_name,
                    'description' => null,
                    'document_section' => $parent_operation->document_section,
                    'document_subsection' => $parent_operation->document_subsection,
                    'start_document_page' => $parent_operation->start_document_page,
                    'end_document_page' => $parent_operation->end_document_page,
                    'actual_document_page' => $parent_operation->actual_document_page,
                    'document_id' => $parent_operation->document_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                // Создание новой связи подработы (подоперации) с техническими системами в БД
                foreach ($parent_operation->technical_systems as $technical_system)
                    DB::table('technical_system_operation')->insert([
                        'operation_id' => $operation_id,
                        'technical_system_id' => $technical_system->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
            }

            // Если дочерняя работа уже была добавлена в БД ранее, то запоминаем ее id
            if ($child_operation)
                $operation_id = $child_operation->id;
            if ($parent_operation and $operation_id) {
                $sequence = $encoding ? mb_convert_encoding($sequence_number, 'utf-8', 'windows-1251') :
                    $sequence_number;
                // Создание новой связи родительской и дочерней работы (подоперации) в БД
                DB::table('operation_hierarchy')->insert([
                    'designation' => $encoding ? mb_convert_encoding($designation, 'utf-8', 'windows-1251') :
                        $designation,
                    'sequence_number' => $sequence != '' ? $sequence : null,
                    'parent_operation_id' => $parent_operation->id,
                    'child_operation_id' => $operation_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                // Создание результатов работ (операций)
                if ($result != '') {
                    $result_name =  $encoding ? mb_convert_encoding($result, 'utf-8', 'windows-1251') : $result;
                    self::createOperationResults($result_name, $operation_id);
                }

                // Создание условий выполнения для работ (операций)
                if ($condition != '') {
                    $cond_name =  $encoding ? mb_convert_encoding($condition, 'utf-8', 'windows-1251') : $condition;
                    self::createOperationConditions($cond_name, $operation_id);
                }

                // Создание причин неисправности для работ (операций)
                if ($cause != '') {
                    $cause_name =  $encoding ? mb_convert_encoding($cause, 'utf-8', 'windows-1251') : $cause;
                    self::createOperationMalfunctionCauses($cause_name, $parent_operation->id, $operation_id);
                }
            }
        }
    }

    /**
     * Get source data on sub-operations and store this data in database.
     *
     * @param bool $encoding - flag to include or exclude encoding conversion from windows-1251 to utf-8
     */
    public function createSubOperations(bool $encoding = false)
    {
        // Пусть к csv-файлу с подработами (подоперациями)
        $file = resource_path() . '/csv/' . self::FILE_NAME;
        // Открываем файл с CSV-данными
        $fh = fopen($file, 'r');
        // Делаем пропуск первой строки, смещая указатель на одну строку
        fgetcsv($fh, 0, ',');
        // Читаем построчно содержимое CSV-файла
        while (($row = fgetcsv($fh, 0, ',')) !== false)
            // Игнорирование пустых строк и строк начинающихся с комментария
            if (array(null) !== $row and array_filter($row) and strncmp($row[0], '/*', 2) !== 0)
                self::addSubOperation($row, $encoding);
    }
}
