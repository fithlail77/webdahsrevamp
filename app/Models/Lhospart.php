<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lhospart extends Model
{
    use HasFactory;

    protected $table = 'spart';

    protected $fillable = [
        'i_no',
        'material_code',
        'name',
        'model',
        'unit',
        'i_qty',
        'i_date',
        'post_date',
        'stor_loct',
        'desc',
        'estate',
        'div',
        'block1',
        'block2',
        'year',
        'tm_tbm',
        'sap_i_no',
        'sap_canc_no',
        'status',
        'return_msg',
        'bulan',
        'no_unit',
        'nama_unit',
        'kelompok_unit',
        'biaya_spart',
    ];
}
