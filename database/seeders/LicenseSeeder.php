<?php

namespace Database\Seeders;

use App\Models\License;
use App\Models\Organization;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LicenseSeeder extends Seeder
{
    public function run()
    {
        DB::table('license')->insert([
            'code' => 'Уникальный код лицензии',
            'name' => 'Название лицензии',
            'description' => 'Описание лицензии',
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now(),
            'type' => License::BASE_TYPE,
            'organization_id' => Organization::find(2)->id,
            'project_id' => Project::first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
