<?php

namespace Database\Seeders;

use App\Components\CSVDataLoader\TechnicalSystemLoader;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TechnicalSystemSeeder extends Seeder
{
    public function run()
    {
        // Загрузка реальных данных по техническим системам и подсистемам самолета
        $data_loader = new TechnicalSystemLoader();
        $data_loader->createTechnicalSystems();

        // Создание тестовой технической системы (альтернативный самолет) и ее подсистем
        $technical_system_id = DB::table('technical_system')->insertGetId([
            'code' => 'Уникальный код технической системы (альтернативный самолет)',
            'name' => 'Название технической системы (альтернативный самолет)',
            'description' => 'Описание технической системы (альтернативный самолет)',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $sub_id = DB::table('technical_system')->insertGetId([
            'code' => 'Уникальный код подситемы 1 для самолета',
            'name' => 'Название подситемы 1 для самолета',
            'description' => 'Описание подситемы 1 для самолета',
            'parent_technical_system_id' => $technical_system_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('technical_system')->insert([
            'code' => 'Уникальный код подситемы 2 для самолета',
            'name' => 'Название подситемы 2 для самолета',
            'description' => 'Описание подситемы 2 для самолета',
            'parent_technical_system_id' => $technical_system_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        $sub_sub_id = DB::table('technical_system')->insertGetId([
            'code' => 'Уникальный код объекта 1 для подсистемы 1',
            'name' => 'Название объекта 1 для подсистемы 1',
            'description' => 'Описание объекта 1 для подсистемы 1',
            'parent_technical_system_id' => $sub_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('technical_system')->insert([
            'code' => 'Уникальный код объекта 2 для подсистемы 1',
            'name' => 'Название объекта 2 для подсистемы 1',
            'description' => 'Описание объекта 2 для подсистемы 1',
            'parent_technical_system_id' => $sub_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('technical_system')->insert([
            'code' => 'Уникальный код элемента для объекта 1',
            'name' => 'Название элемента для объекта 1',
            'description' => 'Описание элемента для объекта 1',
            'parent_technical_system_id' => $sub_sub_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // Создание тестовой технической системы (дельтаплана)
        DB::table('technical_system')->insert([
            'code' => 'Уникальный код технической системы (дельтаплана)',
            'name' => 'Название технической системы (дельтаплана)',
            'description' => 'Описание технической системы (дельтаплана)',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
