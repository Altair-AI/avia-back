<?php

namespace Database\Seeders;

use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Создание супер-администратора по-умолчанию
        DB::table('technical_system')->insert([
            'name' => 'super-admin',
            'email' => 'altair-ii@yandex.ru',
            'role' => 0,
            'status' => 0,
            'full_name' => 'Супер-администратор',
            'last_login_date' => Carbon::now(),
            'login_ip' => '127.0.0.1',
            'organization_id' => Organization::all()->first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // Создание тестового администратора
        DB::table('technical_system')->insert([
            'name' => 'test-admin',
            'email' => 'test-admin@avia-back.ru',
            'role' => 1,
            'status' => 0,
            'full_name' => 'Тестовый администратор',
            'last_login_date' => Carbon::now(),
            'login_ip' => '127.0.0.1',
            'organization_id' => Organization::all()->first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
