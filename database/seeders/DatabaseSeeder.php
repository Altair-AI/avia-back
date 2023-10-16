<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(OrganizationSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TechnicalSystemSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(LicenseSeeder::class);
        $this->call(DocumentSeeder::class);
        $this->call(OperationAndMalfunctionCodeSeeder::class);
        $this->command->info('Данные по-умолчанию загружены в базу данных!');
    }
}
