<?php

namespace Database\Seeders;

use App\Components\CSVDataLoader;
use Illuminate\Database\Seeder;

class MalfunctionCodeSeeder extends Seeder
{
    public function run()
    {
        // Загрузка реальных данных по признакам (кодам) неисправностей
        $data_loader = new CSVDataLoader;
        $data_loader->create_malfunction_codes();
    }
}
