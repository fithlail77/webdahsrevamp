<?php

namespace App\Imports;

use App\Models\Aresta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ArestaImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        return new Aresta([
            'bulan' => $row['bulan'],
            'estate' => $row['estate'],
            'divisi' => $row['divisi'],
            'blok' => $row['blok'],
            'tahun_tanam' => $row['tahun_tanam'],
            'status_tanaman' => $row['status_tanaman'],
            'status_lahan' => $row['status_lahan'],
            'jenis_bibit' => $row['jenis_bibit'],
            'topografi' => $row['topografi'],
            'jenis_tanah' => $row['jenis_tanah'],
            'pokok' => $row['pokok'],
            'luas' =>  $row['luas'],
            'jenis_input' => $row['jenis_input'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
        ]);
    }
}
