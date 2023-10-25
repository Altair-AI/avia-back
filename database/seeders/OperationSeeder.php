<?php

namespace Database\Seeders;

use App\Components\CSVDataLoader;
use App\Models\Document;
use Illuminate\Database\Seeder;

class OperationSeeder extends Seeder
{
    public function run()
    {
        $data_loader = new CSVDataLoader;
        // Загрузка реальных данных по основным работам (операциям) РУН
        $data_loader->create_operations(Document::all()->first()->id);
        // Загрузка реальных данных по под-работам (под-операциям) РУН
        $data_loader->create_sub_operations();
    }
}
