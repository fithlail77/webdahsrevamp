<?php

namespace App\Imports;

use App\Models\ChInput;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ChImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new ChInput([
            'pt' => $row['pt'],
            'dates' => $row['dates'],
            'estate' => $row['estate'],
            'divisi' => $row['divisi'],
            'ch' => $row['ch'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
        ]);
    }
}
