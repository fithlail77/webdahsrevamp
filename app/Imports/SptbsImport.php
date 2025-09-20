<?php

namespace App\Imports;

use App\Models\SptbsInput;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SptbsInputImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(Array $row)
    {
        $tanggal_tiket = null;
        $tanggal_sptbs = null;
        $tanggal_panen = null;

        if (!empty($row['tanggal_tiket'])) {
            try {
                // Jika format string seperti "2025-04-01"
                if (is_string($row['tanggal_tiket'])) {
                    $tanggal_tiket = Carbon::parse($row['tanggal_tiket'])->format('Y-m-d');
                } else {
                    // Jika format numeric (Excel date serial number)
                    $tanggal_tiket = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_tiket']))->format('Y-m-d');
                }
            } catch (\Exception $e) {
                Log::error("Format tanggal error: " . json_encode($row['tanggal_tiket']));
            }
        }

        if (!empty($row['tanggal_sptbs'])) {
            try {
                // Jika format string seperti "2025-04-01"
                if (is_string($row['tanggal_sptbs'])) {
                    $tanggal_sptbs = Carbon::parse($row['tanggal_sptbs'])->format('Y-m-d');
                } else {
                    // Jika format numeric (Excel date serial number)
                    $tanggal_sptbs = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_sptbs']))->format('Y-m-d');
                }
            } catch (\Exception $e) {
                Log::error("Format tanggal error: " . json_encode($row['tanggal_sptbs']));
            }
        }

        if (!empty($row['tanggal_panen'])) {
            try {
                // Jika format string seperti "2025-04-01"
                if (is_string($row['tanggal_panen'])) {
                    $tanggal_panen = Carbon::parse($row['tanggal_panen'])->format('Y-m-d');
                } else {
                    // Jika format numeric (Excel date serial number)
                    $tanggal_panen = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_panen']))->format('Y-m-d');
                }
            } catch (\Exception $e) {
                Log::error("Format tanggal error: " . json_encode($row['tanggal_panen']));
            }
        }

        return new SptbsInput([
            'angkutan' => $row['angkutan'],
            'no_tiket' => $row['no_tiket'],
            'tanggal_tiket' => $tanggal_tiket,
            'no_sptbs' => $row['no_sptbs'],
            'tanggal_sptbs' => $tanggal_sptbs,
            'tanggal_panen' => $tanggal_panen,
            'nama_supir' => $row['nama_supir'],
            'no_polisi' => $row['no_polisi'],
            'jam_masuk' => $row['jam_masuk'],
            'jam_keluar' => $row['jam_keluar'],
            'estate' => $row['estate'],
            'divisi' => $row['divisi'],
            'blok' => $row['blok'],
            'tahun_tanam' => $row['tahun_tanam'],
            'lahan' => $row['lahan'],
            'jumlah_tandan' => $row['jumlah_tandan'],
            'berondolan' => $row['berondolan'],
            'berat_bruto' => $row['berat_bruto'],
            'berat_tarra' => $row['berat_tarra'],
            'berat_netto' => $row['berat_netto'],
            'jumlah_grading' => $row['jumlah_grading'],
            'berat_bersih' => $row['berat_bersih'],
            'bjr' => $row['bjr'],
        ]);
    }
}

