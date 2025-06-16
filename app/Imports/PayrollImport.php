<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Payroll;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PayrollImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        // Handle tanggal kosong atau invalid
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
                \Log::error("Format tanggal error: " . json_encode($row['tanggal']));
            }
        }

        $periode = null;
        if (!empty($row['periode'])) {
            try {
                if(is_string($row['periode'])) {
                    $periode = Carbon::parse($row['periode'])->format('Y-m-d');
                } else {
                    $periode = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['periode']))->format('Y-m-d');
                }
            } catch (\Exception $e) {
                \Log::error("Format tanggal error: " . json_encode($row['periode']));
            }
        }

        // Bersihkan string kosong sebelum disimpan ke model
        foreach ($row as $key => $value) {
            if (is_string($value) && trim($value) === '') {
                $row[$key] = null;
            }
        }

        return new Payroll([
            'estate' => $row['estate'],
            'tanggal' => $tanggal,
            'periode' => $periode,
            'tahun' => $row['tahun'],
            'divisi' => $row['divisi'],
            'nik' => $row['nik'],
            'nama' => $row['nama'],
            'status' => $row['status'],
            'pembayaran' => $row['pembayaran'],
            'blok' => $row['blok'],
            'tahun_tanam' => $row['tahun_tanam'],
            'jenis_pekerjaan' => $row['jenis_pekerjaan'],
            'divisi_2' => $row['divisi_2'],
            'kelompok' => $row['kelompok'],
            'coa' => $row['coa'],
            'ket' => $row['ket'],
            't_rp' => $row['t_rp'],
            'jjg' => $row['jjg'],
            'hasil' => $row['hasil'],
            'sat' => $row['sat'],
            'hasil_2' => $row['hasil_2'],
            'sat_21' => $row['sat_21'],
            'total' => $row['total'],
            'jenis_pupuk' => $row['jenis_pupuk'],
            'jm_1' => $row['jm_1'],
            'qty_1' => $row['qty_1'],
            'sat_1' => $row['sat_1'],
            'jm_2' => $row['jm_2'],
            'qty_2' => $row['qty_2'],
            'sat_2' => $row['sat_2'],
            'jm_3' => $row['jm_3'],
            'qty_3' => $row['qty_3'],
            'sat_3' => $row['sat_3'],
            'nik_mandor' => $row['nik_mandor'],
            'nama_mandor' => $row['nama_mandor'],
            'hk' => $row['hk'],
            'hk1' => $row['hk1'],
        ]);
    }
}
