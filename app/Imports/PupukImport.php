<?php

namespace App\Imports;

use App\Models\Pupukrawat;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PupukImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Pupukrawat([
            'issue_no' => $row['issue_no'], 
            'material_code' => $row['material_code'],
            'material_name' => $row['material_name'],
            'unit' => $row['unit'],
            'issue_qty' => $row['issue_qty'],
            'issue_date' => $row['issue_date'],
            'posting_date' => $row['posting_date'],
            'storage_location' => $row['storage_location'],
            'description' => $row['description'],
            'estate' => $row['estate'],
            'div' => $row['div'],
            'block1' => $row['block1'],
            'block2' => $row['block2'],
            'years' => $row['years'],
            'tm_tbm' => $row['tm_tbm'],
            'sap_issue_no' => $row['sap_issue_no'],
            'kelompok' => $row['kelompok'],
            'jenis_pupuk' => $row['jenis_pupuk'],
            'system_aplikasi' => $row['system_aplikasi'],
            'bln' => $row['bln'],
            'tahun' => $row['tahun'],
            'estate2' => $row['estate2'],
            'divisi' => $row['divisi'],
            'status2' => $row['status2'],
            'areal' => $row['areal'],
            'blok' => $row['blok'],
            'tt' => $row['tt'],
            'programs' => $row['programs'],
            'dosis' => $row['dosis'],
            'jumlah_pokok' => $row['jumlah_pokok'],
            'ha' => $row['ha'], 
            'harga' => $row['harga'],
            'biaya' => $row['biaya'],
        ]);
    }
}
