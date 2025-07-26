<?php

namespace App\Imports;

use App\Models\Lhospart;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class LhospartImport implements ToModel, WithHeadingRow
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
                \Log::error("Format tanggal error: " . json_encode($row['i_date']));
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
                \Log::error("Format tanggal error: " . json_encode($row['post_date']));
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

        return new Lhospart([
            'i_no' => $row['i_no'],
            'material_code' => $row['material_code'],
            'name' => $row['name'],
            'model' => $row['model'],
            'unit' => $row['unit'],
            'i_qty' => $row['i_qty'],
            'i_date' => $i_date,
            'post_date' => $post_date,
            'stor_loct' => $row['stor_loct'],
            'desc' => $row['desc'],
            'estate' => $row['estate'],
            'div' => $row['div'],
            'block1' => $row['block1'],
            'block2' => $row['block2'],
            'year' => $row['year'],
            'tm_tbm' => $row['tm_tbm'],
            'sap_i_no' => $row['sap_i_no'],
            'sap_canc_no' => $row['sap_canc_no'],
            'status' => $row['status'],
            'return_msg' => $row['return_msg'],
            'bulan' => $bulan,
            'no_unit' => $row['no_unit'],
            'nama_unit' => $row['nama_unit'],
            'kelompok_unit' => $row['kelompok_unit'],
            'biaya_spart' => $row['biaya_spart'],
        ]);

    }
}
