<?php

namespace App\Components\CSVDataLoader;

use App\Models\MalfunctionCode;
use App\Models\Operation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MalfunctionCodeLoader
{
    const FILE_NAME = 'malfunction_codes.csv';

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
        $file = resource_path() . '/csv/' . self::FILE_NAME;
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
}
