<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produksicpo extends Model
{
    use HasFactory;

    protected $table = 'produksi_cpo';
    protected $fillable = [
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
        'sisa_produksi_cangkang',
        'stok_cangkang',
        'despatch_cangkang',
        'bulan',
        'tahun',
        'tbs_olah_netto_internal',
        'tbs_olah_netto_eksternal',
        'tbs_olah_netto',
        'oer_after_grading',
        'ker_after_grading',
    ];
}
