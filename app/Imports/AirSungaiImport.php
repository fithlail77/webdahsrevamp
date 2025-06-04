<?php

namespace App\Imports;

use App\Models\AirSungai;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AirSungaiImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        return new AirSungai([
            'tanggal' => $row['tanggal'],
            'pagi_m' => $row['pagi_m'],
            'sore_m' => $row['sore_m'],
            'rataan' => $row['rataan'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
        ]);
    }
}
