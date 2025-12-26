<?php

namespace App\Imports;

use App\Models\TSA;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TsaImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(Array $row)
    {
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
                Log::error("Format tanggal error: " . json_encode($row['tanggal']));
            }
        }

        return new TSA([
            'tanggal' => $tanggal,
            'no_ticket' => $row['no_ticket'],
            'transportir' => $row['transportir'],
            'supir' => $row['nama_supir'],
            'nopol' => $row['no_polisi'],
            'material' => $row['material'],
            'satuan' => $row['satuan'],
            'blok' => $row['blok'],
            'tt' => $row['tahun_tanam'],
            'estate' => $row['estate'],
            'divisi' => $row['divisi'],
            'lahan' => $row['lahan'],
            'bruto' => $row['bruto'],
            'tara' => $row['tarra'],
            'netto' => $row['netto']
        ]);
    }
}
