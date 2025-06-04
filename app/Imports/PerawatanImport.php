<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Perawatan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PerawatanImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        // Handle tanggal kosong atau invalid
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
                \Log::error("Format tanggal error: " . json_encode($row['tanggal']));
            }
        }

        $bulan = null;
        if (!empty($row['bulan'])) {
            try {
                if(is_string($row['bulan'])) {
                    $bulan = Carbon::parse($row['bulan'])->format('Y-m-d');
                } else {
                    $bulan = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['bulan']))->format('Y-m-d');
                }
            } catch (\Exception $e) {
                \Log::error("Format tanggal error: " . json_encode($row['bulan']));
            }
        }

        return new Perawatan([
            'tanggal' => $tanggal,
            'bulan' => $bulan,
            'tahun_jalan' => $row['tahun_jalan'],
            'tahun' => $row['tahun'],
            'nik' => $row['nik'],
            'nama' => $row['nama'],
            'status' => $row['status'],
            'pembayaran' => $row['pembayaran'],
            'blok' => $row['blok'],
            'tt' => $row['tt'],
            'kelompok' => $row['kelompok'],
            'coa' => $row['coa'],
            'ket' => $row['ket'],
            'tarif_rp' => $row['tarif_rp'],
            'bjr' => $row['bjr'],
            'hasil' => $row['hasil'],
            'sat' => $row['sat'],
            'hasil_2' => $row['hasil_2'],
            'sat_2' => $row['sat_2'],
            'total' => $row['total'],
            'periode' => $row['periode'],
            'period_txt' => $row['period_txt'],
            'tahun_period' => $row['tahun_period'],
            'estate' => $row['estate'],
            'divisi' => $row['divisi'],
            'jenis_pekerjaan' => $row['jenis_pekerjaan'],
            'areal' => $row['areal'],
            'keterangan' => $row['keterangan'],
            'sph' => $row['sph'],
            'ha' => $row['ha'],
            'hk' => $row['hk'],
        ]);
    }
}
