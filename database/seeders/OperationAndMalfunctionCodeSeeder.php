<?php

namespace Database\Seeders;

use App\Components\CSVDataLoader;
use App\Models\Document;
use Illuminate\Database\Seeder;

class OperationAndMalfunctionCodeSeeder extends Seeder
{
    public function run()
    {
        // Загрузка реальных данных по работам (операциям) РУН
        $data_loader = new CSVDataLoader;
        $operations = $data_loader->create_operations(Document::all()->first()->id);
        // Загрузка реальных данных по признакам (кодам) неисправностей
        $data_loader->create_malfunction_codes($operations);
    }
}
