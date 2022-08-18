<?php

namespace App;

class FileHelper
{
    /**
     * @param string $baseFilename
     * @param array  $data
     *
     * @return bool
     */
    public static function saveToCSV(string $baseFilename, array $data): bool {
        try {
            if(count($data) > 0){
                $delimiter = ",";
                $filename = $baseFilename. date('Y-m-d') . ".csv";

                $f = fopen($filename, 'x');

                $fields = array_keys((array)$data[0]);
                fputcsv($f, $fields, $delimiter);

                foreach($data as $item){
                    fputcsv($f, (array)$item, $delimiter);
                }

                return true;
            }

            echo "The data is empty.";

            return false;
        } catch (\Throwable $exception) {
            echo(json_encode(['outcome' => false, 'message' => $exception->getTrace()]));

            return false;
        }
    }
}