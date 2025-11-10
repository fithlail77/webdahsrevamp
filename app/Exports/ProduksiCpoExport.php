<?php

namespace App\Exports;

use App\Models\Produksicpo;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProduksiCpoExport implements FromCollection, WithHeadings
{

    protected $minDate;
    protected $maxDate;
    protected $search;

    public function __construct($minDate = null, $maxDate = null, $search = null)
    {
        $this->minDate = $minDate;
        $this->maxDate = $maxDate;
        $this->search = $search;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Produksicpo::select([
            'tanggal',
            'tbs_terima_internal',
            'persen_terima_internal',
            'tbs_terima_eksternal',
            'persen_terima_eksternal',
            'total_tbs_terima',
            'tbs_olah',
            'sisa',
            'cpo_produksi_today',
            'cpo_produksi_todate',
            'ffa_cpo_today',
            'ffa_cpo_todate',
            'kernel_produksi',
            'oer',
            'ker',
            'oil_loss',
            'kernel_loss',
            'stok_cpo_pks_1',
            'stok_cpo_pks_2',
            'stok_cpo_jetty_1',
            'stok_cpo_jetty_2',
            'cpo_despatch_jetty',
            'cpo_despatch_tongkang',
            'stock_nut_produksi',
            'stok_kernel_sistem_proses_silo_1',
            'stok_kernel_sistem_proses_silo_2',
            'stok_kernel_gudang',
            'stok_kernel_st_kernel',
            'stok_kernel_depan_workshop',
            'stok_kernel_st_despatch',
            'stok_kernel_bulking_silo',
            'stok_kernel_total',
            'despatch_kernel',
            'stok_cangkang',
        ]);

        // Jika ada pencarian, ambil semua data tanpa filter tanggal
        if (!empty($this->search)) {
            // Tidak ada filter tanggal
        } else {
            // Jika ada filter tanggal, gunakan itu
            if ($this->minDate && $this->maxDate) {
                $query->whereDate('tanggal', '>=', $this->minDate)->whereDate('tanggal', '<=', $this->maxDate);
            } elseif ($this->minDate) {
                $query->whereDate('tanggal', '>=', $this->minDate);
            } elseif ($this->maxDate) {
                $query->whereDate('tanggal', '<=', $this->maxDate);
            } else {
                // Default: 30 hari ke belakang
                $query->where('tanggal', '>=', \Carbon\Carbon::now()->subDays(30));
            }
        }

        return $query->get()->map(function ($item) {
            return [
                'tanggal' => \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y'),
                'tbs_terima_internal' => $item->tbs_terima_internal,
                'persen_terima_internal' => $item->persen_terima_internal,
                'tbs_terima_eksternal' => $item->tbs_terima_eksternal,
                'persen_terima_eksternal' => $item->persen_terima_eksternal,
                'total_tbs_terima' => $item->total_tbs_terima,
                'tbs_olah' => $item->tbs_olah,
                'sisa' => $item->sisa,
                'cpo_produksi_today' => $item->cpo_produksi_today,
                'cpo_produksi_todate' => $item->cpo_produksi_todate,
                'ffa_cpo_today' => $item->ffa_cpo_today,
                'ffa_cpo_todate' => $item->ffa_cpo_todate,
                'kernel_produksi' => $item->kernel_produksi,
                'oer' => $item->oer,
                'ker' => $item->ker,
                'oil_loss' => $item->oil_loss,
                'kernel_loss' => $item->kernel_loss,
                'stok_cpo_pks_1' => $item->stok_cpo_pks_1,
                'stok_cpo_pks_2' => $item->stok_cpo_pks_2,
                'stok_cpo_jetty_1' => $item->stok_cpo_jetty_1,
                'stok_cpo_jetty_2' => $item->stok_cpo_jetty_2,
                'cpo_despatch_jetty' => $item->cpo_despatch_jetty,
                'cpo_despatch_tongkang' => $item->cpo_despatch_tongkang,
                'stock_nut_produksi' => $item->stock_nut_produksi,
                'stok_kernel_sistem_proses_silo_1' => $item->stok_kernel_sistem_proses_silo_1,
                'stok_kernel_sistem_proses_silo_2' => $item->stok_kernel_sistem_proses_silo_2,
                'stok_kernel_gudang' => $item->stok_kernel_gudang,
                'stok_kernel_st_kernel' => $item->stok_kernel_st_kernel,
                'stok_kernel_depan_workshop'=> $item->stok_kernel_depan_workshop,
                'stok_kernel_st_despatch' => $item->stok_kernel_st_despatch,
                'stok_kernel_bulking_silo' => $item->stok_kernel_bulking_silo,
                'stok_kernel_total' => $item->stok_kernel_total,
                'despatch_kernel' => $item->despatch_kernel,
                'stok_cangkang' => $item->stok_cangkang,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'TBS Internal',
            '% TBS Internal',
            'TBS Eksternal',
            '% TBS Eksternal',
            'Total TBS',
            'Total TBS Olah',
            'Sisa TBS',
            'CPO Today',
            'CPO Todate',
            'Kernal',
            'OER',
            'KER',
            'Oil Loss',
            'Kernel Loss',
            'Storage CPO 1',
            'Storage CPO 2',
            'Storage Jetty',
            'Despatch to Jetty',
            'Despatch Tongkang',
            'Kernel Silo 1',
            'Kernel Silo 1',
            'Kernel Gudang',
            'Kernel Station',
            'Kernel Workshop',
            'Kernel St Despatch',
            'Kernel Bulking Silo',
            'Stok Kernel Total',
            'Despatch Kernel',
            'Cangkang'
        ];
    }
}
