<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\TechnicalSystem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RealTimeTechnicalSystemSeeder extends Seeder
{
    public function run()
    {
        // Создание тестовой технической системы реального времени и ее подсистем
        $real_time_technical_system_id = DB::table('real_time_technical_system')->insertGetId([
            'registration_code' => 'Уникальный код технической системы реального времени',
            'registration_description' => 'Дополнительное описание технической системы реального времени',
            'operation_time_from_start' => 0,
            'operation_time_from_last_repair' => 0,
            'technical_system_id' => TechnicalSystem::first()->id,
            'project_id' => Project::first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // Создание доступа пользователей (техников) к реальным техническим системам
        DB::table('real_time_technical_system_user')->insert([
            'real_time_technical_system_id' => $real_time_technical_system_id,
            'user_id' => User::whereId(3)->first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
