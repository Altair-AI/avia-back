<?php

namespace App\Components;

use App\Models\MalfunctionCode;
use App\Models\Operation;
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
    public function create_technical_systems(bool $encoding = false) {
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
    public function create_operations(int $document_id, bool $encoding = false) {
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
     * Get source data on sub-operations and store this data in database.
     *
     * @param bool $encoding - flag to include or exclude encoding conversion from windows-1251 to utf-8
     * @return array|false|string|string[]|null
     */
    public function create_sub_operations(bool $encoding = false) {
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
                $result, $condition) = $row;
            array_push($sub_operations, [$child_operation_code, $designation, $imperative_name,
                $parent_operation_code, $verbal_name, $result, $condition]);

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
                    // Создание новой связи родительской и дочерней работы (подоперации) в БД
                    DB::table('operation_hierarchy')->insert([
                        'designation' => $encoding ? mb_convert_encoding($designation, 'utf-8', 'windows-1251') :
                            $designation,
                        'parent_operation_id' => $parent_operation->id,
                        'child_operation_id' => $operation_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                    if ($result != "") {
                        // Создание нового результата работы (операции) в БД
                        $operation_result_id = DB::table('operation_result')->insertGetId([
                            'name' => $encoding ? mb_convert_encoding($result, 'utf-8', 'windows-1251') : $result,
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
                    if ($condition != "") {
                        // Создание нового условия работы (операции) в БД
                        $operation_condition_id = DB::table('operation_condition')->insertGetId([
                            'name' => $encoding ? mb_convert_encoding($condition, 'utf-8', 'windows-1251') : $condition,
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
    public function create_malfunction_codes(bool $encoding = false) {
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

            // Поиск технической системы через код операции (работы)
            $parent_technical_system_id = null;
            $operation = Operation::where('code', $operation_code)->first();
            if ($operation)
                foreach ($operation->technical_systems as $technical_system)
                    $parent_technical_system_id = $technical_system->id;

            if ($operation and $emergency_msg != "") {
                // Создание нового признака (кода) неисправности в БД - Аварийно‐сигнальное сообщение
                $malfunction_code_id = DB::table('malfunction_code')->insertGetId([
                    'name' => $encoding ? mb_convert_encoding($emergency_msg, 'utf-8', 'windows-1251') : $emergency_msg,
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
                // Создание нового признака (кода) неисправности в БД - Сообщение БСТО
                $bsto = $bsto_source . " " . $bsto_in . " " . $bsto_description;
                $malfunction_code_id = DB::table('malfunction_code')->insertGetId([
                    'name' => $encoding ? mb_convert_encoding($bsto, 'utf-8', 'windows-1251') : $bsto,
                    'type' => MalfunctionCode::BSTO_TYPE,
                    'source' => $encoding ? mb_convert_encoding($bsto_source, 'utf-8', 'windows-1251') : $bsto_source,
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
                // Создание нового признака (кода) неисправности в БД - Сигнализация СЭИ
                $malfunction_code_id = DB::table('malfunction_code')->insertGetId([
                    'name' => $encoding ? mb_convert_encoding($sei, 'utf-8', 'windows-1251') : $sei,
                    'type' => MalfunctionCode::SEI_TYPE,
                    'source' => $encoding ? mb_convert_encoding($mnemonic_coder, 'utf-8', 'windows-1251') :
                        $mnemonic_coder,
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
                // Создание нового признака (кода) неисправности в БД - Локальная сигнализация
                $alternative_name = $encoding ? mb_convert_encoding($local_alternative, 'utf-8', 'windows-1251') :
                    $local_alternative;
                $malfunction_code_id = DB::table('malfunction_code')->insertGetId([
                    'name' => $encoding ? mb_convert_encoding($local, 'utf-8', 'windows-1251') : $local,
                    'type' => MalfunctionCode::LOCAL_TYPE,
                    'source' => $encoding ? mb_convert_encoding($elec_desk, 'utf-8', 'windows-1251') : $elec_desk,
                    'alternative_name' => $alternative_name != "" ? $alternative_name : null,
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
}
