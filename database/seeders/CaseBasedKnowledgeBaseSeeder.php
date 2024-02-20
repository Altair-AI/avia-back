<?php

namespace Database\Seeders;

use App\Models\CaseBasedKnowledgeBase;
use App\Models\RealTimeTechnicalSystem;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaseBasedKnowledgeBaseSeeder extends Seeder
{
    public function run()
    {
        // Создание прецедентной базы знаний
        $case_based_knowledge_base_id = DB::table('case_based_knowledge_base')->insertGetId([
            'name' => 'Тестовая прецедентная база знаний',
			'description' => 'Описание тестовой прецедентной базы знаний',
            'status' => CaseBasedKnowledgeBase::PRIVATE_STATUS,
            'correctness' => CaseBasedKnowledgeBase::INCORRECT_TYPE,
            'author' => User::first()->id,
			'real_time_technical_system_id' => RealTimeTechnicalSystem::first()->id,
			'project_id' => Project::first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // Создание последствий неисправности
        DB::table('malfunction_consequence')->insert([
            'name' => 'Без последствий',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // Создание этапов обнаружения неисправности
        DB::table('malfunction_detection_stage')->insert([
            'name' => 'На земле - ОТО',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('malfunction_detection_stage')->insert([
            'name' => 'В полете - Заход на посадку',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
		]);
        DB::table('malfunction_detection_stage')->insert([
            'name' => 'На земле - Подготовка к вылету',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
		]);
        // Создание прецедентов
        DB::table('case')->insert([
            'date' => '2020-07-18',
            'card_number' => '46',
            'operation_time_from_start' => null,
            'operation_time_from_last_repair' => null,
			'malfunction_detection_stage_id' => 1,
			'malfunction_cause_id' => 55,
			'system_id_for_repair' => RealTimeTechnicalSystem::first()->id,
			'initial_completed_operation_id' => null,
			'case_based_knowledge_base_id' => $case_based_knowledge_base_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
		]);
        DB::table('case')->insert([
            'date' => '2019-07-17',
            'card_number' => '645',
            'operation_time_from_start' => null,
            'operation_time_from_last_repair' => null,
			'malfunction_detection_stage_id' => 1,
			'malfunction_cause_id' => 5,
			'system_id_for_repair' => RealTimeTechnicalSystem::first()->id,
			'initial_completed_operation_id' => null,
			'case_based_knowledge_base_id' => $case_based_knowledge_base_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
		]);
        DB::table('case')->insert([
            'date' => '2018-04-23',
            'card_number' => '329',
            'operation_time_from_start' => null,
            'operation_time_from_last_repair' => null,
			'malfunction_detection_stage_id' => 2,
			'malfunction_cause_id' => 55,
			'system_id_for_repair' => RealTimeTechnicalSystem::first()->id,
			'initial_completed_operation_id' => null,
			'case_based_knowledge_base_id' => $case_based_knowledge_base_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
		// Создание кодов неисправностей в прецедентах
        DB::table('malfunction_code_case')->insert([
            'case_id' => 1,
            'malfunction_code_id' => 117,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
		]);
        DB::table('malfunction_code_case')->insert([
            'case_id' => 2,
            'malfunction_code_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
		]);
        DB::table('malfunction_code_case')->insert([
            'case_id' => 3,
            'malfunction_code_id' => 40,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // Создание последствий неисправности в прецеденте
        DB::table('malfunction_consequence_case')->insert([
            'case_id' => 1,
            'malfunction_consequence_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
		]);
        DB::table('malfunction_consequence_case')->insert([
		    'case_id' => 2,
            'malfunction_consequence_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
		]);
        DB::table('malfunction_consequence_case')->insert([
            'case_id' => 3,
            'malfunction_consequence_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
