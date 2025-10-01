<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Aramco;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AramcoImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(Array $row)
    {
        $tanggal_rakit = null;
        $tanggal_pasang = null;

        if (!empty($row['tanggal_rakit'])) {
            try {
                // Jika format string seperti "2025-04-01"
                if (is_string($row['tanggal_rakit'])) {
                    $tanggal_rakit = Carbon::parse($row['tanggal_rakit'])->format('Y-m-d');
                } else {
                    // Jika format numeric (Excel date serial number)
                    $tanggal_rakit = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_rakit']))->format('Y-m-d');
                }
            } catch (\Exception $e) {
                Log::error("Format tanggal error: " . json_encode($row['tanggal_rakit']));
            }
        }

        if (!empty($row['tanggal_pasang'])) {
            try {
                // Jika format string seperti "2025-04-01"
                if (is_string($row['tanggal_pasang'])) {
                    $tanggal_pasang = Carbon::parse($row['tanggal_pasang'])->format('Y-m-d');
                } else {
                    // Jika format numeric (Excel date serial number)
                    $tanggal_pasang = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_pasang']))->format('Y-m-d');
                }
            } catch (\Exception $e) {
                Log::error("Format tanggal error: " . json_encode($row['tanggal_pasang']));
            }
        }

        return new Aramco([
            'tanggal_rakit' => $tanggal_rakit,
            'tanggal_pasang' => $tanggal_pasang,
            'no_po' => $row['no_po'],
            'ukuran' => $row['ukuran'],
            'jumlah' => $row['jumlah'],
            'satuan' => $row['satuan'],
            'blok' => $row['blok'],
            'estate' => $row['estate'],
            'divisi' => $row['divisi'],
            'kordinat' => $row['kordinat'],
            'tahun_tanam' => $row['tahun_tanam'],
            'lahan' => $row['lahan'],
            'status' => $row['status']
        ]);
    }
}
