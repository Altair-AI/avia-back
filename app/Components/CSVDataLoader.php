<?php

namespace App\Components;

use App\Models\MalfunctionCause;
use App\Models\MalfunctionCauseOperation;
use App\Models\MalfunctionCauseRule;
use App\Models\MalfunctionCauseRuleThen;
use App\Models\MalfunctionCode;
use App\Models\Operation;
use App\Models\OperationCondition;
use App\Models\OperationResult;
use App\Models\TechnicalSystem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CSVDataLoader
{
    /**
     * Get source data on technical systems including subsystems and objects, and store this data in database.
     *
     * @param bool $encoding - flag to include or exclude encoding conversion from windows-1251 to utf-8
     * @return array|false|string|string[]|null
     */
    public function create_technical_systems(bool $encoding = false)
    {
        $technical_systems = [];
        // Пусть к csv-файлу с техническими системами
        $file = resource_path() . '/csv/systems.csv';
        // Открываем файл с CSV-данными
        $fh = fopen($file, "r");
        // Делаем пропуск первой строки, смещая указатель на одну строку
        fgetcsv($fh, 0, ';');
        // Читаем построчно содержимое CSV-файла
        while (($row = fgetcsv($fh, 0, ';')) !== false) {
            list($code, $name, $parent, $comment) = $row;
            array_push($technical_systems, [$code, $name, $parent, $comment]);

            // Поиск родительской технической системы по коду
            $parent_technical_system_id = null;
            if ($parent != "")
                foreach (TechnicalSystem::where('code', $parent)->get() as $technical_system)
                    $parent_technical_system_id = $technical_system->id;

            // Формирование описания технической системы
            $description = $encoding ? mb_convert_encoding($comment, 'utf-8', 'windows-1251') : $comment;

            // Создание новой технической системы в БД
            DB::table('technical_system')->insert([
                'code' => $code != "" ? $code : null,
                'name' => $encoding ? mb_convert_encoding($name, 'utf-8', 'windows-1251') : $name,
                'description' => $description != "" ? $description : null,
                'parent_technical_system_id' => $parent_technical_system_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        return $encoding ? mb_convert_encoding($technical_systems, 'utf-8', 'windows-1251') : $technical_systems;
    }

    /**
     * Get source data on operations and store this data in database.
     *
     * @param int $document_id - id target document
     * @param bool $encoding - flag to include or exclude encoding conversion from windows-1251 to utf-8
     * @return array|false|string|string[]|null
     */
    public function create_operations(int $document_id, bool $encoding = false)
    {
        $operations = [];
        // Пусть к csv-файлу с работами (операциями)
        $file = resource_path() . '/csv/operations.csv';
        // Открываем файл с CSV-данными
        $fh = fopen($file, "r");
        // Делаем пропуск первой строки, смещая указатель на одну строку
        fgetcsv($fh, 0, ';');
        // Читаем построчно содержимое CSV-файла
        while (($row = fgetcsv($fh, 0, ';')) !== false) {
            list($name, $operation_code, $section, $subsection, $system_code,
                $start_page, $end_page, $actual_page) = $row;
            array_push($operations, [$name, $operation_code, $section, $subsection, $system_code,
                $start_page, $end_page, $actual_page]);

            // Создание новой работы (операции) в БД
            $operation_id = DB::table('operation')->insertGetId([
                'code' => $encoding ? mb_convert_encoding($operation_code, 'utf-8', 'windows-1251') : $operation_code,
                'type' => Operation::BASIC_OPERATION_TYPE,
                'imperative_name' => null,
                'verbal_name' => $encoding ? mb_convert_encoding($name, 'utf-8', 'windows-1251') : $name,
                'description' => null,
                'document_section' => $section,
                'document_subsection' => $subsection,
                'start_document_page' => $start_page,
                'end_document_page' => $end_page != "" ? $end_page : null,
                'actual_document_page' => $actual_page != "" ? $actual_page : null,
                'document_id' => $document_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Создание новой связи работы (операции) с техническими системами/подсистемами/объектами в БД
            if ($system_code != "")
                foreach (TechnicalSystem::where('code', $system_code)->get() as $technical_system)
                    DB::table('technical_system_operation')->insert([
                        'operation_id' => $operation_id,
                        'technical_system_id' => $technical_system->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
        }
        return $encoding ? mb_convert_encoding($operations, 'utf-8', 'windows-1251') : $operations;
    }

    /**
     * Create new operation results in database.
     *
     * @param bool $encoding - flag to include or exclude encoding conversion from windows-1251 to utf-8
     * @param string $result - operation results in the form of source string
     * @param int|null $operation_id - id operation
     */
    public function create_operation_results(bool $encoding = false, string $result = "", int $operation_id = null)
    {
        if ($result != "" and !is_null($operation_id)) {
            $full_result_name =  $encoding ? mb_convert_encoding($result, 'utf-8', 'windows-1251') : $result;
            $result_names = explode(" / ", $full_result_name);
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
                // Создание новой связи результата работы (операции) с конкретной работой (операцией) в БД
                DB::table('concrete_operation_result')->insert([
                    'operation_id' => $operation_id,
                    'operation_result_id' => $operation_result_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }

    /**
     * Create new operation conditions in database.
     *
     * @param bool $encoding - flag to include or exclude encoding conversion from windows-1251 to utf-8
     * @param string $condition - operation conditions in the form of source string
     * @param int|null $operation_id - id operation
     */
    public function create_operation_conditions(bool $encoding = false, string $condition = "",
                                                int $operation_id = null)
    {
        if ($condition != "" and !is_null($operation_id)) {
            $condition_name =  $encoding ? mb_convert_encoding($condition, 'utf-8', 'windows-1251') :
                $condition;
            // Поиск условия работы (операции)
            $operation_condition = OperationCondition::where('name', $condition_name)->first();
            if ($operation_condition)
                $operation_condition_id = $operation_condition->id;
            else
                // Создание нового условия работы (операции) в БД
                $operation_condition_id = DB::table('operation_condition')->insertGetId([
                    'name' => $condition_name,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            // Создание новой связи условия работы (операции) с конкретной работой (операцией) в БД
            DB::table('concrete_operation_condition')->insert([
                'operation_id' => $operation_id,
                'operation_condition_id' => $operation_condition_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    /**
     * Create new malfunction causes for operations in database.
     *
     * @param bool $encoding - flag to include or exclude encoding conversion from windows-1251 to utf-8
     * @param string $cause - malfunction cause in the form of source string
     * @param int|null $parent_operation_id - id parent operation
     * @param int|null $child_operation_id - id child operation
     */
    public function create_operation_malfunction_causes(
        bool $encoding = false,
        string $cause = "",
        int $parent_operation_id = null,
        int $child_operation_id = null
    )
    {
        if ($cause != "" and !is_null($parent_operation_id) and !is_null($child_operation_id)) {
            $cause_name =  $encoding ? mb_convert_encoding($cause, 'utf-8', 'windows-1251') : $cause;
            // Поиск причины неисправности
            $malfunction_cause = MalfunctionCause::where('name', $cause_name)->first();
            if ($malfunction_cause)
                $malfunction_cause_id = $malfunction_cause->id;
            else
                // Создание новой причины неисправности в БД
                $malfunction_cause_id = DB::table('malfunction_cause')->insertGetId([
                    'name' => $cause_name,
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
                    'priority' => 100 - ($mco_count * 10),
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
                    'priority' => 100 - ($mco_count * 10),
                    'operation_id' => $child_operation_id,
                    'malfunction_cause_id' => $malfunction_cause_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }

    /**
     * Get source data on sub-operations and store this data in database.
     *
     * @param bool $encoding - flag to include or exclude encoding conversion from windows-1251 to utf-8
     * @return array|false|string|string[]|null
     */
    public function create_sub_operations(bool $encoding = false)
    {
        $sub_operations = [];
        // Пусть к csv-файлу с подработами (подоперациями)
        $file = resource_path() . '/csv/suboperations.csv';
        // Открываем файл с CSV-данными
        $fh = fopen($file, "r");
        // Делаем пропуск первой строки, смещая указатель на одну строку
        fgetcsv($fh, 0, ';');
        // Читаем построчно содержимое CSV-файла
        while (($row = fgetcsv($fh, 0, ';')) !== false) {
            list($child_operation_code, $designation, $imperative_name, $parent_operation_code, $verbal_name,
                $sequence_number, $result, $condition, $cause) = $row;
            array_push($sub_operations, [$child_operation_code, $designation, $imperative_name,
                $parent_operation_code, $verbal_name, $sequence_number, $result, $condition, $cause]);

            if ($child_operation_code != "" and $parent_operation_code != "") {
                $operation_id = null;
                // Поиск родительской работы по коду
                $parent_operation = Operation::where('code', $parent_operation_code)->first();
                // Поиск дочерней работы по коду
                $child_operation = Operation::where('code', $child_operation_code)->first();
                // Если родительская работа с таким кодом есть в БД, а дочерней работы нет
                if ($parent_operation and !$child_operation) {
                    // Создание новой подработы (подоперации) в БД
                    $operation_id = DB::table('operation')->insertGetId([
                        'code' => $encoding ? mb_convert_encoding($child_operation_code, 'utf-8', 'windows-1251') :
                            $child_operation_code,
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
                        'sequence_number' => $sequence != "" ? $sequence : null,
                        'parent_operation_id' => $parent_operation->id,
                        'child_operation_id' => $operation_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                    // Создание результатов работ (операций)
                    self::create_operation_results($encoding, $result, $operation_id);
                    // Создание условий выполнения для работ (операций)
                    self::create_operation_conditions($encoding, $condition, $operation_id);
                    // Создание причин неисправности для работ (операций)
                    self::create_operation_malfunction_causes($encoding, $cause, $parent_operation->id, $operation_id);
                }
            }
        }
        return $encoding ? mb_convert_encoding($sub_operations, 'utf-8', 'windows-1251') : $sub_operations;
    }

    /**
     * Get source data on malfunction codes and store this data in database.
     *
     * @param bool $encoding - flag to include or exclude encoding conversion from windows-1251 to utf-8
     * @return array|false|string|string[]|null
     */
    public function create_malfunction_codes(bool $encoding = false)
    {
        $malfunction_codes = [];
        // Пусть к csv-файлу с признаками (кодами) неисправности
        $file = resource_path() . '/csv/malfunction_codes.csv';
        // Открываем файл с CSV-данными
        $fh = fopen($file, "r");
        // Делаем пропуск первой строки, смещая указатель на одну строку
        fgetcsv($fh, 0, ';');
        // Читаем построчно содержимое CSV-файла
        while (($row = fgetcsv($fh, 0, ';')) !== false) {
            list($emergency_msg, $bsto_source, $bsto_in, $bsto_description, $operation_code, $sei, $mnemonic_coder,
                $errors, $local, $local_alternative, $elec_desk, $observed_faults) = $row;
            array_push($malfunction_codes, [$emergency_msg, $bsto_source, $bsto_in, $bsto_description,
                $operation_code, $sei, $mnemonic_coder, $errors, $local, $local_alternative, $elec_desk,
                $observed_faults]);

            $bsto = $bsto_source . " " . $bsto_in . " " . $bsto_description;
            if ($encoding) {
                $emergency_msg = mb_convert_encoding($emergency_msg, 'utf-8', 'windows-1251');
                $bsto = mb_convert_encoding($bsto, 'utf-8', 'windows-1251');
                $bsto_source = mb_convert_encoding($bsto_source, 'utf-8', 'windows-1251');
                $sei = mb_convert_encoding($sei, 'utf-8', 'windows-1251');
                $mnemonic_coder = mb_convert_encoding($mnemonic_coder, 'utf-8', 'windows-1251');
                $local = mb_convert_encoding($local, 'utf-8', 'windows-1251');
                $local_alternative = mb_convert_encoding($local_alternative, 'utf-8', 'windows-1251');
                $elec_desk = mb_convert_encoding($elec_desk, 'utf-8', 'windows-1251');
                $observed_faults = mb_convert_encoding($observed_faults, 'utf-8', 'windows-1251');
            }

            // Поиск технической системы через код операции (работы)
            $parent_technical_system_id = null;
            $operation = Operation::where('code', $operation_code)->first();
            if ($operation)
                foreach ($operation->technical_systems as $technical_system)
                    $parent_technical_system_id = $technical_system->id;

            if ($operation and $emergency_msg != "") {
                // Поиск кода неисправности
                $malfunction_code = MalfunctionCode::where('name', $emergency_msg)->first();
                if ($malfunction_code)
                    $malfunction_code_id = $malfunction_code->id;
                else
                    // Создание нового признака (кода) неисправности в БД - Аварийно‐сигнальное сообщение
                    $malfunction_code_id = DB::table('malfunction_code')->insertGetId([
                        'name' => $emergency_msg,
                        'type' => MalfunctionCode::EMRG_TYPE,
                        'source' => null,
                        'alternative_name' => null,
                        'technical_system_id' => $parent_technical_system_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                // Создание новой связи признака (кода) неисправности с работой (операцией)
                DB::table('operation_malfunction_code')->insert([
                    'operation_id' => $operation->id,
                    'malfunction_code_id' => $malfunction_code_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            if ($operation and $bsto_source != "" and $bsto_in != "" and $bsto_description != "") {
                // Поиск кода неисправности
                $malfunction_code = MalfunctionCode::where('name', $bsto)->first();
                if ($malfunction_code)
                    $malfunction_code_id = $malfunction_code->id;
                else
                    // Создание нового признака (кода) неисправности в БД - Сообщение БСТО
                    $malfunction_code_id = DB::table('malfunction_code')->insertGetId([
                        'name' => $bsto,
                        'type' => MalfunctionCode::BSTO_TYPE,
                        'source' => $bsto_source,
                        'alternative_name' => null,
                        'technical_system_id' => $parent_technical_system_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                // Создание новой связи признака (кода) неисправности с работой (операцией)
                DB::table('operation_malfunction_code')->insert([
                    'operation_id' => $operation->id,
                    'malfunction_code_id' => $malfunction_code_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            if ($operation and $sei != "") {
                // Поиск кода неисправности
                $malfunction_code = MalfunctionCode::where('name', $sei)->first();
                if ($malfunction_code)
                    $malfunction_code_id = $malfunction_code->id;
                else
                    // Создание нового признака (кода) неисправности в БД - Сигнализация СЭИ
                    $malfunction_code_id = DB::table('malfunction_code')->insertGetId([
                        'name' => $sei,
                        'type' => MalfunctionCode::SEI_TYPE,
                        'source' => $mnemonic_coder,
                        'alternative_name' => null,
                        'technical_system_id' => $parent_technical_system_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                // Создание новой связи признака (кода) неисправности с работой (операцией)
                DB::table('operation_malfunction_code')->insert([
                    'operation_id' => $operation->id,
                    'malfunction_code_id' => $malfunction_code_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            if ($operation and $local != "") {
                // Поиск кода неисправности
                $malfunction_code = MalfunctionCode::where('name', $local)->first();
                if ($malfunction_code)
                    $malfunction_code_id = $malfunction_code->id;
                else
                    // Создание нового признака (кода) неисправности в БД - Локальная сигнализация
                    $malfunction_code_id = DB::table('malfunction_code')->insertGetId([
                        'name' => $local,
                        'type' => MalfunctionCode::LOCAL_TYPE,
                        'source' => $elec_desk,
                        'alternative_name' => $local_alternative != "" ? $local_alternative : null,
                        'technical_system_id' => $parent_technical_system_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                // Создание новой связи признака (кода) неисправности с работой (операцией)
                DB::table('operation_malfunction_code')->insert([
                    'operation_id' => $operation->id,
                    'malfunction_code_id' => $malfunction_code_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            if ($operation and $observed_faults != "") {
                // Поиск кода неисправности
                $malfunction_code = MalfunctionCode::where('name', $observed_faults)->first();
                if ($malfunction_code)
                    $malfunction_code_id = $malfunction_code->id;
                else
                    // Создание нового признака (кода) неисправности в БД - Наблюдаемые неисправности
                    $malfunction_code_id = DB::table('malfunction_code')->insertGetId([
                        'name' => $observed_faults,
                        'type' => MalfunctionCode::OBS_TYPE,
                        'source' => null,
                        'alternative_name' => null,
                        'technical_system_id' => $parent_technical_system_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                // Создание новой связи признака (кода) неисправности с работой (операцией)
                DB::table('operation_malfunction_code')->insert([
                    'operation_id' => $operation->id,
                    'malfunction_code_id' => $malfunction_code_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
        return $encoding ? mb_convert_encoding($malfunction_codes, 'utf-8', 'windows-1251') : $malfunction_codes;
    }

    /**
     * Get source data on malfunction causes and store this data in database.
     *
     * @param int $knowledge_base_id - id target rule based knowledge base
     * @param bool $encoding - flag to include or exclude encoding conversion from windows-1251 to utf-8
     * @return array|false|string|string[]|null
     */
    public function create_malfunction_cause_rules(int $knowledge_base_id, bool $encoding = false)
    {
        $malfunction_causes = [];
        $operation_codes = [];
        // Пусть к csv-файлу с причинами неисправностей
        $file = resource_path() . '/csv/malfunction_causes.csv';
        // Открываем файл с CSV-данными
        $fh = fopen($file, "r");
        // Делаем пропуск первой строки, смещая указатель на одну строку
        fgetcsv($fh, 0, ';');
        // Читаем построчно содержимое CSV-файла
        while (($row = fgetcsv($fh, 0, ';')) !== false) {
            list($operation_code, $cause) = $row;
            array_push($malfunction_causes, [$operation_code, $cause]);

            // Поиск работы (операции) по коду
            $operation = Operation::where('code', $operation_code)->first();
            // Если работа найдена
            if ($operation) {
                // Если код работы встречается впервые при чтении данного файла
                if (!in_array($operation_code, $operation_codes)) {
                    // Создание нового правила для базы знаний правил в БД
                    $malfunction_cause_rule_id = DB::table('malfunction_cause_rule')->insertGetId([
                        'description' => null,
                        'document_id' => $operation->document_id,
                        'rule_based_knowledge_base_id' => $knowledge_base_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                    // Создание условий для правила (коды неисправности для правила)
                    foreach ($operation->malfunction_codes as $malfunction_code)
                        DB::table('malfunction_cause_rule_if')->insert([
                            'malfunction_cause_rule_id' => $malfunction_cause_rule_id,
                            'malfunction_code_id' => $malfunction_code->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    // Создание действий для правила (системы, которые соответствуют кодам неисправности для правила)
                    foreach ($operation->technical_systems as $technical_system)
                        DB::table('malfunction_cause_rule_then')->insert([
                            'malfunction_cause_rule_id' => $malfunction_cause_rule_id,
                            'technical_system_id' => $technical_system->id,
                            'operation_id' => $operation->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    // Добавление текущего кода работы в общий массив с кодами
                    array_push($operation_codes, $operation_code);
                } else
                    $malfunction_cause_rule_id = MalfunctionCauseRule::whereIn('id',
                        MalfunctionCauseRuleThen::select(['malfunction_cause_rule_id'])
                        ->where('operation_id', $operation->id))->first()->id;
                // Формирование названия причины неисправности
                $cause_name = $encoding ? mb_convert_encoding($cause, 'utf-8', 'windows-1251') : $cause;
                // Поиск причины неисправности по названию
                $malfunction_cause = MalfunctionCause::where('name', $cause_name)->first();
                // Создание новой причины неисправности, если ее нет в БД
                if ($malfunction_cause)
                    $malfunction_cause_id = $malfunction_cause->id;
                else
                    $malfunction_cause_id = DB::table('malfunction_cause')->insertGetId([
                        'name' => $cause_name,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                // Создание связи причины неисправности с правилом
                DB::table('malfunction_cause_rule_malfunction_cause')->insert([
                    'malfunction_cause_rule_id' => $malfunction_cause_rule_id,
                    'malfunction_cause_id' => $malfunction_cause_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
        return $encoding ? mb_convert_encoding($malfunction_causes, 'utf-8', 'windows-1251') : $malfunction_causes;
    }

    /**
     * Get operation result id.
     *
     * @param String $operation_result_name - name of operation result from rule condition or action
     * @return int|mixed|null
     */
    public function get_operation_result(String $operation_result_name)
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
        $file = resource_path() . '/csv/operation_rules.csv';
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
                $operation_result_id_if = self::get_operation_result($operation_result_name_if);
                $operation_result_id_then = self::get_operation_result($operation_result_name_then);

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
