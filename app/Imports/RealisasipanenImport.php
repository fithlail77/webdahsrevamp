<?php

namespace App\Imports;

use App\Models\RealisasiPanen;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RealisasipanenImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        $tanggal = null;
        if (!empty($row['date'])) {
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

        return new RealisasiPanen([
            'tanggal' => $row['tanggal'],
            'jenis_kerja' => $row['jenis_kerja'],
            'blok' => $row['blok'],
            'tt' => $row['tt'],
            'divisi' => $row['divisi'],
            'estate' => $row['estate'],
            'hasil' => $row['hasil'],
            'satuan' => $row['satuan'],
            'tk' => $row['tk'],
            'ha_panen' => $row['ha_panen'],
        ]);
    }
}
