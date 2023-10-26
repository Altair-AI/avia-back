<?php

namespace Database\Seeders;

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
        DB::table('rule_based_knowledge_base')->insert([
            'name' => 'База знаний с правилами для самолета',
            'description' => 'Описание базы знаний с правилами для самолета',
            'status' => RuleBasedKnowledgeBase::PUBLIC_STATUS,
            'correctness' => RuleBasedKnowledgeBase::CORRECT_TYPE,
            'author' => User::first()->id,
            'technical_system_id' => TechnicalSystem::first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
