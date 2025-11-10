<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Produksicpo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProduksicpoImport implements ToModel, WithHeadingRow
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

        return new Produksicpo([
            'tanggal' => $tanggal,
            'tbs_terima_internal' => $row['tbs_terima_internal'],
            'persen_terima_internal' => $row['persen_terima_internal'],
            'tbs_terima_eksternal' => $row['tbs_terima_eksternal'],
            'persen_terima_eksternal' => $row['persen_terima_eksternal'],
            'total_tbs_terima' => $row['total_tbs_terima'],
            'tbs_olah' => $row['tbs_olah'],
            'sisa' => $row['sisa'],
            'cpo_produksi_today' => $row['cpo_produksi_today'],
            'cpo_produksi_todate' => $row['cpo_produksi_todate'],
            'ffa_cpo_today' => $row['ffa_cpo_today'],
            'ffa_cpo_todate' => $row['ffa_cpo_todate'],
            'kernel_produksi' => $row['kernel_produksi'],
            'oer' => $row['oer'],
            'ker' => $row['ker'],
            'oil_loss' => $row['oil_loss'],
            'kernel_loss' => $row['kernel_loss'],
            'stok_cpo_pks_1' => $row['stok_cpo_pks_1'],
            'stok_cpo_pks_2' => $row['stok_cpo_pks_2'],
            'stok_cpo_jetty_1' => $row['stok_cpo_jetty_1'],
            'stok_cpo_jetty_2' => $row['stok_cpo_jetty_2'],
            'cpo_despatch_jetty' => $row['cpo_despatch_jetty'],
            'cpo_despatch_tongkang' => $row['cpo_despatch_tongkang'],
            'stock_nut_produksi' => $row['stock_nut_produksi'],
            'stok_kernel_sistem_proses_silo_1' => $row['stok_kernel_sistem_proses_silo_1'],
            'stok_kernel_sistem_proses_silo_2' => $row['stok_kernel_sistem_proses_silo_2'],
            'stok_kernel_gudang' => $row['stok_kernel_gudang'],
            'stok_kernel_st_kernel' => $row['stok_kernel_st_kernel'],
            'stok_kernel_depan_workshop' => $row['stok_kernel_depan_workshop'],
            'stok_kernel_st_despatch' => $row['stok_kernel_st_despatch'],
            'stok_kernel_bulking_silo' => $row['stok_kernel_bulking_silo'],
            'stok_kernel_total' => $row['stok_kernel_total'],
            'despatch_kernel' => $row['despatch_kernel'],
            'sisa_produksi_cangkang' => $row['sisa_produksi_cangkang'],
            'stok_cangkang' => $row['stok_cangkang'],
            'despatch_cangkang' => $row['despatch_cangkang'],
            'bulan' => $bulan,
            'tahun' => $row['tahun'],
            'tbs_olah_netto_internal' => $row['tbs_olah_netto_internal'],
            'tbs_olah_netto_eksternal' => $row['tbs_olah_netto_eksternal'],
            'tbs_olah_netto' => $row['tbs_olah_netto'],
            'oer_after_grading' => $row['oer_after_grading'],
            'ker_after_grading' => $row['ker_after_grading'],
        ]);
    }
}
