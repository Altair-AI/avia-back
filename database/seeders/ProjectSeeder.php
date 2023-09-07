<?php

namespace Database\Seeders;

use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        DB::table('project')->insert([
            'name' => 'Название проекта',
            'description' => 'Описание проекта',
            'type' => 0,
            'status' => 0,
            'technical_system_id' => Organization::all()->first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
