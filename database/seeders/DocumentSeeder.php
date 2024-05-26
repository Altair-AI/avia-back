<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\TechnicalSystem;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentSeeder extends Seeder
{
    public function run()
    {
        // Создание документа
        $document_id = DB::table('document')->insertGetId([
            'code' => '24',
            'name' => 'RRJ-95 РУКОВОДСТВО ПО ПОИСКУ И УСТРАНЕНИЮ НЕИСПРАВНОСТЕЙ. РАЗДЕЛ 24 — СИСТЕМА ЭЛЕКТРОСНАБЖЕНИЯ',
            'type' => Document::TROUBLESHOOTING_GUIDE_TYPE,
            'version' => 'Дек 30/21',
            'file' => 'RRj95_FIM_24.pdf',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // Создание связи документа с технической системой (самолетом)
        DB::table('technical_system_document')->insert([
            'document_id' => $document_id,
            'technical_system_id' => TechnicalSystem::first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
