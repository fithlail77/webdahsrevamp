<?php

namespace App\Imports;


use Carbon\Carbon;
use App\Models\LsuInput;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LsuInputImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new LsuInput([
            'tahun' => $row['tahun'],
            'blok' => $row['blok'],
            'estate' => $row['estate'],
            'divisi' => $row['divisi'],
            'tahun_tanam' => $row['tahun_tanam'],
            'blok_tt' => $row['blok_tt'],
            'luas' => $row['luas'],
            'pokok' => $row['pokok'],
            'lsu' => $row['lsu'],
            'unsur_hara' => $row['unsur_hara'],
            'updated_at' => $row['updated_at'],
            'created_at' => $row['created_at'],
        ]);
    }
}
