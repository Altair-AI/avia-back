<?php

namespace Database\Seeders;

use App\Components\CSVDataLoader\OperationLoader;
use App\Components\CSVDataLoader\SubOperationLoader;
use App\Models\Document;
use Illuminate\Database\Seeder;

class OperationSeeder extends Seeder
{
    public function run()
    {
        // Загрузка реальных данных по основным работам (операциям) РУН
        $data_loader = new OperationLoader();
        $data_loader->createOperations(Document::all()->first()->id);

        // Загрузка реальных данных по под-работам (под-операциям) РУН
        $data_loader = new SubOperationLoader();
        $data_loader->createSubOperations();
    }
}
