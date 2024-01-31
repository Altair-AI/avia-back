<?php

namespace App\Components\CSVDataLoader;

use App\Models\MalfunctionCause;
use App\Models\MalfunctionCauseOperation;
use App\Models\MalfunctionCauseRule;
use App\Models\MalfunctionCauseRuleThen;
use App\Models\Operation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MalfunctionCauseRuleLoader
{
    const FILE_NAME = 'malfunction_causes.csv';

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
        $file = resource_path() . '/csv/' . self::FILE_NAME;
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

                // Создание новой связи причины неисправности с работой (операцией) РУН в БД (если ее там нет)
                $mc_operation = MalfunctionCauseOperation::where('operation_id', $operation->id)
                    ->where('malfunction_cause_id', $malfunction_cause_id)
                    ->first();
                if (!$mc_operation) {
                    $mco_count = MalfunctionCauseOperation::where('operation_id', $operation->id)->count();
                    DB::table('malfunction_cause_operation')->insert([
                        'priority' => 100 - ($mco_count * 10),
                        'operation_id' => $operation->id,
                        'malfunction_cause_id' => $malfunction_cause_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }

        return $encoding ? mb_convert_encoding($malfunction_causes, 'utf-8', 'windows-1251') : $malfunction_causes;
    }
}
