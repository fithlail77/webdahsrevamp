<?php

namespace App\Imports;

use App\Models\PerawatanKebun;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PerawatanKebunImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(Array $row)
    {
        $tanggal = null;

        if (!empty($row['tanggal'])) {
            try {
                // Jika format string seperti "2025-04-01"
                if (is_string($row['tanggal'])) {
                    $tanggal = Carbon::parse($row['tanggal'])->format('Y-m-d');
                } else {
                    // Jika format numeric (Excel date serial number)
                    $tanggal = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal']))->format('Y-m-d');
                }
            } catch (\Exception $e) {
                Log::error("Format tanggal error: " . json_encode($row['tanggal']));
            }
        }

        return new PerawatanKebun([
            'tanggal' => $tanggal,
            'jenis_perawatan' => $row['jenis_perawatan'],
            'blok' => $row['blok'],
            'tahun_tanam' => $row['tahun_tanam'],
            'divisi' => $row['divisi'],
            'estate' => $row['estate'],
            'lahan' => $row['lahan'],
            'hasil' => $row['hasil'],
            'satuan' => $row['satuan'],
            'jml_tenaga' => $row['jml_tenaga'],
            'material_1' => $row['material_1'],
            'jumlah_1' => $row['jumlah_1'],
            'satuan_1' => $row['satuan_1'],
            'material_2' => $row['material_2'],
            'jumlah_2' => $row['jumlah_2'],
            'satuan_2' => $row['satuan_2'],
            'material_3' => $row['material_3'],
            'jumlah_3' => $row['jumlah_3'],
            'satuan_3' => $row['satuan_3'],
            'keterangan' => $row['keterangan']
        ]);
    }
}
