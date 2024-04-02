<?php

namespace App\Components\CSVDataExporter;

class CSVFileExporter
{
    /**
     * Export data array to csv file.
     *
     * @param string $file_name
     * @param array $data
     */
    public static function export(string $file_name, array $data)
    {
        $fp = fopen($file_name,'wb');
        foreach ($data as $row)
            fwrite($fp, implode(';', $row) . "\r\n");
        fclose($fp);

        header('Content-type: text/csv');
        header('Content-Disposition: inline; filename=' . $file_name);
        readfile($file_name);

        exit;
    }
}
