<?php

namespace App\Components\CSVDataLoader;

use App\Models\TechnicalSystem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TechnicalSystemLoader
{
    const FILE_NAME = 'systems.csv';

    /**
     * Add new technical system to database.
     *
     * @param array $row - row with data
     * @param bool $encoding - flag to include or exclude encoding conversion from windows-1251 to utf-8
     */
    public function addTechnicalSystems(array $row, bool $encoding = false)
    {
        list($code, $name, $parent, $comment) = $row;
        // Поиск родительской технической системы по коду
        $parent_technical_system_id = null;
        if ($parent != '')
            foreach (TechnicalSystem::where('code', $parent)->get() as $technical_system)
                $parent_technical_system_id = $technical_system->id;

        // Формирование описания технической системы
        $description = $encoding ? mb_convert_encoding($comment, 'utf-8', 'windows-1251') : $comment;

        // Создание новой технической системы в БД
        DB::table('technical_system')->insert([
            'code' => $code != '' ? $code : null,
            'name' => $encoding ? mb_convert_encoding($name, 'utf-8', 'windows-1251') : $name,
            'description' => $description != '' ? $description : null,
            'parent_technical_system_id' => $parent_technical_system_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    /**
     * Get source data on technical systems including subsystems and objects, and store this data in database.
     *
     * @param bool $encoding - flag to include or exclude encoding conversion from windows-1251 to utf-8
     */
    public function createTechnicalSystems(bool $encoding = false)
    {
        // Пусть к csv-файлу с техническими системами
        $file = resource_path() . '/csv/' . self::FILE_NAME;
        // Открываем файл с CSV-данными
        $fh = fopen($file, 'r');
        // Делаем пропуск первой строки, смещая указатель на одну строку
        fgetcsv($fh, 0, ';');
        // Читаем построчно содержимое CSV-файла
        while (($row = fgetcsv($fh, 0, ';')) !== false)
            self::addTechnicalSystems($row, $encoding);
    }
}
