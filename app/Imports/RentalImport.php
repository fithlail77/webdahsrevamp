<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Rental;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RentalImport implements ToModel, WithHeadingRow
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

        return new Rental([
            'tanggal' => $tanggal,
            'estate' => $row['estate'],
            'jenis_alat' => $row['jenis_alat'],
            'no_alat' => $row['no_alat'],
            'operator' => $row['operator'],
            'hm_awal' => $row['hm_awal'],
            'hm_akhir' => $row['hm_akhir'],
            'total_hm' => $row['total_hm'],
            'potongan_hm' => $row['potongan_hm'],
            'pembayaran_hm' => $row['pembayaran_hm'],
            'blok' => $row['blok'],
            'tahun_tanam' => $row['tahun_tanam'],
            'pekerjaan' => $row['pekerjaan'],
            'divisi' => $row['divisi'],
            'kelompok' => $row['kelompok'],
            'coa' => $row['coa'],
            'tarif' => $row['tarif'],
            'bjr' => $row['bjr'],
            'hasil_1' => $row['hasil_1'],
            'satuan_1' => $row['satuan_1'],
            'hasil_2' => $row['hasil_2'],
            'satuan_2' => $row['satuan_2'],
            'total_biaya' => $row['total_biaya'],
        ]);
    }
}
