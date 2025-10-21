<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Ffbeksternal;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FfbeksternalImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        $tanggal = null;
        $bulan = null;

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
        
        return new Ffbeksternal([
            'no_po' => $row['no_po'],
            'vendor_detail' => $row['vendor_detail'],
            'vendor_group' => $row['vendor_group'],
            'vendor_transportir' => $row['vendor_transportir'],
            'tgl' => $row['tgl'],
            'bln' => $row['bln'],
            'thn' => $row['thn'],
            'tanggal' => $tanggal,
            'time_in' => $this->parseTime($row['time_in']),
            'time_out' => $this->parseTime($row['time_out']),
            'no_plat' => $row['no_plat'],
            'driver' => $row['driver'],
            'bruto_awal' => $row['bruto_awal'],
            'tarra' => $row['tarra'],
            'ton_bruto' => $row['ton_bruto'],
            'grading' => $row['grading'],
            'netto' => $row['netto'],
            'jml_tandan' => $row['jml_tandan'],
            'bjr' => $row['bjr'],
            'area' => $row['area'],
            'umur_tanaman' => $row['umur_tanaman'],
            'bulan' => $bulan,
            'estate' => $row['estate'],
            'divisi' => $row['divisi'],
            'asal_tbs' => $row['asal_tbs'],
            'est_div' => $row['est_div'],
            'bln_name' => $row['bln_name'],
        ]);
    }

    private function parseTime($value)
    {
        if (is_numeric($value)) {
            // Format dari Excel sebagai angka (serial time)
            return Carbon::instance(Date::excelToDateTimeObject($value))->format('H:i:s');
        }

        try {
            // Format string, misalnya "07:30" atau "15:45:00"
            return Carbon::parse($value)->format('H:i:s');
        } catch (\Exception $e) {
            return null; // atau '00:00:00' jika kamu ingin default
        }
    }
}
