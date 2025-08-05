<?php

namespace App\Imports;

use App\Models\Lhoinput;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LhoinputImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */

    private function convertExcelTimeToHms($value)
    {
        try {
            if (is_numeric($value)) {
                $totalSeconds = round($value * 86400); // 1 hari = 86400 detik
                $hours = floor($totalSeconds / 3600);
                $minutes = floor(($totalSeconds % 3600) / 60);
                $seconds = $totalSeconds % 60;

                return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
            }

            // Jika sudah dalam string "hh:mm:ss" (misalnya dari Excel text format), validasi pakai Carbon:
            $carbon = Carbon::createFromFormat('H:i:s', $value);
            return $carbon->format('H:i:s');
        } catch (\Exception $e) {
            \Log::warning("Format jam tidak valid: " . json_encode($value));
            return '00:00:00';
        }
    }

    public function model(array $row)
    {
        $tgl = null;
        if (!empty($row['tgl'])) {
            try {
                // Jika format string seperti "2025-04-01"
                if (is_string($row['tgl'])) {
                    $tgl = Carbon::parse($row['cap_on'])->format('Y-m-d');
                } else {
                    // Jika format numeric (Excel date serial number)
                    $tgl = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl']))->format('Y-m-d');
                }
            } catch (\Exception $e) {
                \Log::error("Format tanggal error: " . json_encode($row['tgl']));
            }
        }

        $bulan = null;
        if (!empty($row['bulan'])) {
            try {
                // Jika format string seperti "2025-04-01"
                if (is_string($row['bulan'])) {
                    $bulan = Carbon::parse($row['bulan'])->format('Y-m-d');
                } else {
                    // Jika format numeric (Excel date serial number)
                    $bulan = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['bulan']))->format('Y-m-d');
                }
            } catch (\Exception $e) {
                \Log::error("Format tanggal error: " . json_encode($row['bulan']));
            }
        }

        return new Lhoinput([
            'tgl' => $tgl,
            'hari' => $row['hari'],
            'bulan' => $bulan,
            'no_unit' => $row['no_unit'],
            'nama_unit' => $row['nama_unit'],
            'kelompok_unit' => $row['kelompok_unit'],
            'nik' => $row['nik'],
            'nama_operator' => $row['nama_operator'],
            'jam_awal' => $this->convertExcelTimeToHms($row['jam_awal']),
            'jam_akhir' => $this->convertExcelTimeToHms($row['jam_akhir']),
            'total_jam' => $this->convertExcelTimeToHms($row['total_jam']),
            'hm_awal' => $row['hm_awal'],
            'hm_akhir' => $row['hm_akhir'],
            'hm' => $row['hm'],
            'blok' => $row['blok'],
            'estate' => $row['estate'],
            'divisi' => $row['divisi'],
            'aktivitas' => $row['aktivitas'],
            'detail_kerja_old' => $row['detail_kerja_old'],
            'jenis_kerja_old' => $row['jenis_kerja_old'],
            'kelompok_old' => $row['kelompok_old'],
            'hasil' => $row['hasil'],
            'sat' => $row['sat'],
            'ket' => $row['ket'],
            'hk' => $row['hk'],
            'hk2' => $row['hk2'],
            'rp_per_hm' => $row['rp_per_hm'],
            'total_biaya' => $row['total_biaya'],
            'pengguna' => $row['pengguna'],
            'detail_kerja' => $row['detail_kerja'],
            'jenis_kerja' => $row['jenis_kerja'],
            'kelompok_kerja' => $row['kelompok_kerja'],
            'kelompok_hm' => $row['kelompok_hm'],
            'hm_kerja' => $row['hm_kerja'],
            'hm_travel' => $row['hm_travel'],
            'jam_standby' => $row['jam_standby'],
            'jam_service' => $row['jam_service'],
            'total_hm' => $row['total_hm'],
            'muatan' => $row['muatan'],
            'sat_2' => $row['sat_2'],
        ]);
    }
}
