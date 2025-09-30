<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\PemupukanKebun;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PemupukanKebunImport implements ToModel, WithHeadingRow
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

        return new PemupukanKebun([
            'tanggal' => $tanggal,
            'jenis_pupuk' => $row['jenis_pupuk'],
            'blok' => $row['blok'],
            'tahun_tanam' => $row['tahun_tanam'],
            'divisi' => $row['divisi'],
            'estate' => $row['estate'],
            'lahan' => $row['lahan'],
            'hasil' => $row['hasil'],
            'pokok' => $row['pokok'],
            'dosis' => $row['dosis'],
            'jml_tenaga' => $row['jml_tenaga'],
            'keterangan' => $row['keterangan'],
        ]);
    }
}
