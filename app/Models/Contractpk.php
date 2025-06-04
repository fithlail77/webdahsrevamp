<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractpk extends Model
{
    use HasFactory;

    protected $table = 'contract_kernel';

    protected $fillable = [
        'ltc',
        'nomor_sc',
        'bln_name',
        'date_pricing',
        'price',
        'dicount_ggu',
        'real_price',
        'dp_date',
        'rencana_awal_kirim',
        'rencana_closed_kirim',
        'actual_awal_kirim',
        'actual_closed_kirim',
        'qty_kontrak_kg',
        'buyer',
        'status',
        'real_qty_kg',
        'buyer_received_qty_kg',
        'rp',
        'keterangan',
        'bulan',
    ];
}
