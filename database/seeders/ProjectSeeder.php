<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\TechnicalSystem;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        DB::table('project')->insert([
            'name' => 'Тестовый проект',
            'description' => 'Описание тестового проекта',
            'type' => Project::PUBLIC_TYPE,
            'status' => Project::UNDER_EDITING_STATUS,
            'technical_system_id' => TechnicalSystem::first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
