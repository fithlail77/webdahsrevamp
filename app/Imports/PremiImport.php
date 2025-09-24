<?php

namespace App\Imports;

use App\Models\Premi;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PremiImport implements ToModel, WithHeadingRow
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

        return new Premi([
            'tanggal' => $tanggal,
            'no_kab' => $row['no_kab'],
            'nama_kab' => $row['nama_kab'],
            'nik' => $row['nik'],
            'nama_karyawan' => $row['nama_karyawan'],
            'estate' => $row['estate'],
            'hmkm_awal' => $row['hmkm_awal'],
            'hmkm_akhir' => $row['hmkm_akhir'],
            'total_hmkm' => $row['total_hmkm'],
            'lokasi' => $row['lokasi'],
            'divisi' => $row['divisi'],
            'jenis_pekerjaan' => $row['jenis_pekerjaan'],
            'tarif_satuan' => $row['tarif_satuan'],
            'hasil_1' => $row['hasil_1'],
            'satuan_1' => $row['satuan_1'],
            'hasil_2' => $row['hasil_2'],
            'satuan_2' => $row['satuan_2'],
            'total_premi' => $row['total_premi'],
        ]);
    }
}
