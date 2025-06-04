<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractcpo extends Model
{
    use HasFactory;

    protected $table = 'contract_cpo';
    protected $fillable = [
        'ggu_sc',
        'gum_sc',
        'plan_loading_tk',
        'real_loading_tk',
        'tgl_ba_loading_tk',
        'tgl_pricing',
        'real_price',
        'nilai_penjualan',
        'kontrak_qty_ton',
        'real_qty_kg',
        'kapal_tongkang',
        'suhu',
        'buyer',
        'status',
        'lama_loading_hari',
        'real_loading',
        'bulan',
        'bln_name',
        'plan_bln_name',
    ];
}
