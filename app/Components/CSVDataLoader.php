<?php

namespace App\Components;

use App\Models\MalfunctionCode;
use App\Models\TechnicalSystem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CSVDataLoader
{
    /**
     * Get source data on technical systems including subsystems and objects, and store this data in database.
     *
     * @param bool $encoding
     * @return array|false|string|string[]|null
     */
    public function create_technical_systems(bool $encoding = true) {
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
     * @param int $document_id
     * @param bool $encoding
     * @return array|false|string|string[]|null
     */
    public function create_operations(int $document_id, bool $encoding = true) {
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
            DB::table('operation')->insert([
                'code' => $operation_code,
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
        }
        return $encoding ? mb_convert_encoding($operations, 'utf-8', 'windows-1251') : $operations;
    }

    /**
     * Get source data on malfunction codes and store this data in database.
     *
     * @param array $operations
     * @param bool $encoding
     * @return array|false|string|string[]|null
     */
    public function create_malfunction_codes(array $operations, bool $encoding = true) {
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
            if ($operation_code != "")
                foreach ($operations as $operation)
                    if ($operation_code == $operation[1]) {
                        $technical_system_code = $operation[4];
                        foreach (TechnicalSystem::where('code', $technical_system_code)->get() as $technical_system)
                            $parent_technical_system_id = $technical_system->id;
                    }

            // Создание нового признака (кода) неисправности в БД - Аварийно‐сигнальное сообщение
            if ($emergency_msg != "")
                DB::table('malfunction_code')->insert([
                    'name' => $encoding ? mb_convert_encoding($emergency_msg, 'utf-8', 'windows-1251') : $emergency_msg,
                    'type' => MalfunctionCode::EMRG_TYPE,
                    'source' => null,
                    'alternative_name' => null,
                    'technical_system_id' => $parent_technical_system_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            // Создание нового признака (кода) неисправности в БД - Сообщение БСТО
            if ($bsto_source != "" and $bsto_in != "" and $bsto_description != "") {
                $bsto = $bsto_source . " " . $bsto_in . " " . $bsto_description;
                DB::table('malfunction_code')->insert([
                    'name' => $encoding ? mb_convert_encoding($bsto, 'utf-8', 'windows-1251') : $bsto,
                    'type' => MalfunctionCode::BSTO_TYPE,
                    'source' => $encoding ? mb_convert_encoding($bsto_source, 'utf-8', 'windows-1251') : $bsto_source,
                    'alternative_name' => null,
                    'technical_system_id' => $parent_technical_system_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
            // Создание нового признака (кода) неисправности в БД - Сигнализация СЭИ
            if ($sei != "")
                DB::table('malfunction_code')->insert([
                    'name' => $encoding ? mb_convert_encoding($sei, 'utf-8', 'windows-1251') : $sei,
                    'type' => MalfunctionCode::SEI_TYPE,
                    'source' => $encoding ? mb_convert_encoding($mnemonic_coder, 'utf-8', 'windows-1251') :
                        $mnemonic_coder,
                    'alternative_name' => null,
                    'technical_system_id' => $parent_technical_system_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            // Создание нового признака (кода) неисправности в БД - Локальная сигнализация
            if ($local != "") {
                $alternative_name = $encoding ? mb_convert_encoding($local_alternative, 'utf-8', 'windows-1251') :
                    $local_alternative;
                DB::table('malfunction_code')->insert([
                    'name' => $encoding ? mb_convert_encoding($local, 'utf-8', 'windows-1251') : $local,
                    'type' => MalfunctionCode::LOCAL_TYPE,
                    'source' => $encoding ? mb_convert_encoding($elec_desk, 'utf-8', 'windows-1251') : $elec_desk,
                    'alternative_name' => $alternative_name != "" ? $alternative_name : null,
                    'technical_system_id' => $parent_technical_system_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
        return $encoding ? mb_convert_encoding($malfunction_codes, 'utf-8', 'windows-1251') : $malfunction_codes;
    }
}
