<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    public function run()
    {
        DB::table('organization')->insert([
            'name' => 'Тестовая организация',
            'description' => 'Тестовая организация',
            'actual_address' => 'Фактический адрес организации',
            'legal_address' => 'Юридический адрес организации',
            'phone' => 'Телефон',
            'tin' => 'ИНН/КПП',
            'rboc' => 'ОКПО',
            'psrn' => 'ОГРН',
            'bank_account' => 'Банковский счет',
            'bank_name' => 'Название банка',
            'bik' => 'БИК',
            'correspondent_account' => 'Корреспондентский счет',
            'full_director_name' => 'ФИО директора',
            'treaty_number' => 'Номер договора с организацией',
            'treaty_date' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
