<?php

namespace App\Imports;

use App\Models\LhoDepre;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LhodepreImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        $cap_on = null;
        if (!empty($row['cap_on'])) {
            try {
                // Jika format string seperti "2025-04-01"
                if (is_string($row['cap_on'])) {
                    $cap_on = Carbon::parse($row['cap_on'])->format('Y-m-d');
                } else {
                    // Jika format numeric (Excel date serial number)
                    $cap_on = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['cap_on']))->format('Y-m-d');
                }
            } catch (\Exception $e) {
                Log::error("Format tanggal error: " . json_encode($row['cap_on']));
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
                Log::error("Format tanggal error: " . json_encode($row['bulan']));
            }
        }

        return new LhoDepre([
            'no_unit' => $row['no_unit'],
            'nama_unit' => $row['nama_unit'],
            'aset' => $row['aset'],
            'cap_on' => $cap_on,
            'aset_desc' => $row['aset_desc'],
            'acq_val' => $row['acq_val'],
            'bulan' => $bulan,
            'depre' => $row['depre'],
        ]);
    }
}
