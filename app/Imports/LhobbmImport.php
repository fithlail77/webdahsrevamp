<?php

namespace App\Imports;

use App\Models\LhoBbm;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LhobbmImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        $i_date = null;
        if (!empty($row['i_date'])) {
            try {
                // Jika format string seperti "2025-04-01"
                if (is_string($row['i_date'])) {
                    $i_date = Carbon::parse($row['i_date'])->format('Y-m-d');
                } else {
                    // Jika format numeric (Excel date serial number)
                    $i_date = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['i_date']))->format('Y-m-d');
                }
            } catch (\Exception $e) {
                Log::error("Format tanggal error: " . json_encode($row['i_date']));
            }
        }

        $post_date = null;
        if (!empty($row['post_date'])) {
            try {
                // Jika format string seperti "2025-04-01"
                if (is_string($row['post_date'])) {
                    $post_date = Carbon::parse($row['post_date'])->format('Y-m-d');
                } else {
                    // Jika format numeric (Excel date serial number)
                    $post_date = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['post_date']))->format('Y-m-d');
                }
            } catch (\Exception $e) {
                Log::error("Format tanggal error: " . json_encode($row['post_date']));
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

        return new LhoBbm([
            'i_no' => $row['i_no'],
            'material_code' => $row['material_code'],
            'name' => $row['name'],
            'unit' => $row['unit'],
            'i_qty' => $row['i_qty'],
            'i_date' => $i_date,
            'post_date' => $post_date,
            'stor_loct' => $row['stor_loct'],
            'desc' => $row['desc'],
            'bulan' => $bulan,
            'no_unit' => $row['no_unit'],
            'nama_unit' => $row['nama_unit'],
            'kelompok_unit' => $row['kelompok_unit'],
            'biaya_bbm' => $row['biaya_bbm'],
        ]);
    }
}
