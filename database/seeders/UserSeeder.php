<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Создание супер-администратора по-умолчанию
        DB::table('users')->insert([
            'name' => 'super-admin',
            'email' => 'altair-ii@yandex.ru',
            'password' => bcrypt('altair-super-admin'),
            'role' => User::SUPER_ADMIN_ROLE,
            'status' => User::ACTIVE_STATUS,
            'full_name' => 'Супер-администратор',
            'last_login_date' => Carbon::now(),
            'login_ip' => '127.0.0.1',
            'organization_id' => Organization::first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // Создание тестового администратора
        DB::table('users')->insert([
            'name' => 'test-admin',
            'email' => 'test-admin@avia-back.ru',
            'password' => bcrypt('altair-admin'),
            'role' => User::ADMIN_ROLE,
            'status' => User::ACTIVE_STATUS,
            'full_name' => 'Тестовый администратор',
            'last_login_date' => Carbon::now(),
            'login_ip' => '127.0.0.1',
            'organization_id' => Organization::find(2)->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // Создание тестового техника
        DB::table('users')->insert([
            'name' => 'test-technician',
            'email' => 'test-technician@avia-back.ru',
            'password' => bcrypt('altair-technician'),
            'role' => User::TECHNICIAN_ROLE,
            'status' => User::ACTIVE_STATUS,
            'full_name' => 'Тестовый техник',
            'last_login_date' => Carbon::now(),
            'login_ip' => '127.0.0.1',
            'organization_id' => Organization::find(2)->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
