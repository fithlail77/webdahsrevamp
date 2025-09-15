<?php

namespace App\Imports;

use App\Models\Lhospart;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class LhospartImport implements ToModel, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        $i_date = $this->parseDate($row['i_date'] ?? null);
        $post_date = $this->parseDate($row['post_date'] ?? null);
        $bulan = $this->parseDate($row['bulan'] ?? null);

        return new Lhospart([
            'i_no' => $row['i_no'] ?? null,
            'material_code' => $row['material_code'] ?? null,
            'name' => $row['name'] ?? null,
            'model' => $row['model'] ?? null,
            'unit' => $row['unit'] ?? null,
            'i_qty' => $row['i_qty'] ?? null,
            'i_date' => $i_date,
            'post_date' => $post_date,
            'stor_loct' => $row['stor_loct'] ?? null,
            'desc' => $row['desc'] ?? null,
            'estate' => $row['estate'] ?? null,
            'div' => $row['div'] ?? null,
            'block1' => $row['block1'] ?? null,
            'block2' => $row['block2'] ?? null,
            'year' => $row['year'] ?? null,
            'tm_tbm' => $row['tm_tbm'] ?? null,
            'sap_i_no' => $row['sap_i_no'] ?? null,
            'sap_canc_no' => $row['sap_canc_no'] ?? null,
            'status' => $row['status'] ?? null,
            'return_msg' => $row['return_msg'] ?? null,
            'bulan' => $bulan,
            'no_unit' => $row['no_unit'] ?? null,
            'nama_unit' => $row['nama_unit'] ?? null,
            'kelompok_unit' => $row['kelompok_unit'] ?? null,
            'biaya_spart' => $row['biaya_spart'] ?? null,
        ]);

    }

    private function parseDate($dateValue) {
        if (empty($dateValue)) {
            return null;
        }
        try {
            if (is_string($dateValue)) {
                return Carbon::parse($dateValue)->format('Y-m-d');
            } else {
                return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dateValue))->format('Y-m-d');
            }
        } catch (\Exception $e) {
            Log::error("Format tanggal error: " . json_encode($dateValue));
            return null;
        }
    }
}
