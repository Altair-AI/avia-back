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
            'code' => 'Уникальный код документа',
            'name' => 'Название документа',
            'type' => Document::TROUBLESHOOTING_GUIDE_TYPE,
            'version' => 'Версия документа',
            'file' => 'Путь к файлу документа',
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
