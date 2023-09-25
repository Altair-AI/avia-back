<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TechnicalSystemSeeder extends Seeder
{
    public function run()
    {
        DB::table('technical_system')->insert([
            'code' => 'Уникальный код технической системы или объекта',
            'name' => 'Название системы или объекта',
            'description' => 'Описание системы или объекта',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
