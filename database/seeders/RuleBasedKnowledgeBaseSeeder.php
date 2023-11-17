<?php

namespace Database\Seeders;

use App\Components\CSVDataLoader;
use App\Models\Document;
use App\Models\Project;
use App\Models\RuleBasedKnowledgeBase;
use App\Models\TechnicalSystem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuleBasedKnowledgeBaseSeeder extends Seeder
{
    public function run()
    {
        // Создание базы знаний правил для самолета по умолчанию
        $knowledge_base_id = DB::table('rule_based_knowledge_base')->insertGetId([
            'name' => 'База знаний с правилами для самолета',
            'description' => 'Описание базы знаний с правилами для самолета',
            'status' => RuleBasedKnowledgeBase::PUBLIC_STATUS,
            'correctness' => RuleBasedKnowledgeBase::CORRECT_TYPE,
            'author' => User::first()->id,
            'technical_system_id' => TechnicalSystem::first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // Создание связи базы знаний правил для самолета с тестовым проектом
        DB::table('rule_based_knowledge_base_project')->insert([
            'rule_based_knowledge_base_id' => $knowledge_base_id,
            'project_id' => Project::first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // Создание правил для базы знаний правил
        $data_loader = new CSVDataLoader;
        // Загрузка реальных данных по причинам неисправностей РУН
        $data_loader->create_malfunction_cause_rules($knowledge_base_id);
        // Загрузка реальных данных по правилам последовательности работ (операций)
        $data_loader->create_operation_rules($knowledge_base_id);
    }
}
