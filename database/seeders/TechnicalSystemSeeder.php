<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TechnicalSystemSeeder extends Seeder
{
    public function run()
    {
        // Создание технической системы (самолета)
        DB::table('technical_system')->insert([
            'code' => 'Уникальный код технической системы (самолета)',
            'name' => 'Название технической системы (самолета)',
            'description' => 'Описание технической системы (самолета)',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('technical_system')->insert([
            'code' => 'Уникальный код подситемы 1 для самолета',
            'name' => 'Название подситемы 1 для самолета',
            'description' => 'Описание подситемы 1 для самолета',
            'parent_technical_system_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('technical_system')->insert([
            'code' => 'Уникальный код подситемы 2 для самолета',
            'name' => 'Название подситемы 2 для самолета',
            'description' => 'Описание подситемы 2 для самолета',
            'parent_technical_system_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('technical_system')->insert([
            'code' => 'Уникальный код объекта 1 для подсистемы 1',
            'name' => 'Название объекта 1 для подсистемы 1',
            'description' => 'Описание объекта 1 для подсистемы 1',
            'parent_technical_system_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('technical_system')->insert([
            'code' => 'Уникальный код объекта 2 для подсистемы 1',
            'name' => 'Название объекта 2 для подсистемы 1',
            'description' => 'Описание объекта 2 для подсистемы 1',
            'parent_technical_system_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('technical_system')->insert([
            'code' => 'Уникальный код элемента для объекта 1',
            'name' => 'Название элемента для объекта 1',
            'description' => 'Описание элемента для объекта 1',
            'parent_technical_system_id' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // Создание технической системы (дельтаплана)
        DB::table('technical_system')->insert([
            'code' => 'Уникальный код технической системы (дельтаплана)',
            'name' => 'Название технической системы (дельтаплана)',
            'description' => 'Описание технической системы (дельтаплана)',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
