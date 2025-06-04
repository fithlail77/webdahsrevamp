<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ffbeksternal extends Model
{
    use HasFactory;

    protected $table = 'ffb_eksternal';
    protected $fillable = [
        'id',
        'no_po',
        'vendor_detail',
        'vendor_group',
        'vendor_transportir',
        'tgl',
        'bln',
        'thn',
        'tanggal',
        'time_in',
        'time_out',
        'no_plat',
        'driver',
        'bruto_awal',
        'tarra',
        'ton_bruto',
        'grading',
        'netto',
        'jml_tandan',
        'bjr',
        'area',
        'umur_tanaman',
        'bulan',
        'estate',
        'divisi',
        'asal_tbs',
        'est_div',
        'bln_name',
    ];
}
