<?php

namespace App\Imports;

use App\Models\Aws;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AwsImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        $date = null;
        if (!empty($row['date'])) {
            try {
                // Jika format string seperti "2025-04-01"
                if (is_string($row['date'])) {
                    $date = Carbon::parse($row['date'])->format('Y-m-d');
                } else {
                    // Jika format numeric (Excel date serial number)
                    $date = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date']))->format('Y-m-d');
                }
            } catch (\Exception $e) {
                \Log::error("Format tanggal error: " . json_encode($row['date']));
            }
        }

        return new Aws([
            'time' => $row['time'],
            'date' => $date,
            'temp' => $row['temp'],
            'humid' => $row['humid'],
            'sol_rad' => $row['sol_rad'],
            'rainfall' => $row['rainfall'],
            'air_pres' => $row['air_pres'],
            'wind_speed' => $row['wind_speed'],
            'wind_dir' => $row['wind_dir'],
            'et' => $row['et'],
            'sunshine' => $row['sunshine'],
            'index_uv' => $row['index_uv'],
            'bulan' => $row['bulan'],
            'tahun' => $row['tahun'],
            'rainfall_2' => $row['rainfall_2'],
            'waktu_hujan' => $row['waktu_hujan'],
            'et_2' => $row['et_2'],
            'sunshine_2' => $row['sunshine_2'],
        ]);
    }
}
