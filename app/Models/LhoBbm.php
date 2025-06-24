<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LhoBbm extends Model
{
    use HasFactory;

    protected $table = "bbm";

    protected $fillable = [
        'i_no',
        'material_code',
        'name',
        'unit',
        'i_qty',
        'i_date',
        'post_date',
        'stor_loct',
        'desc',
        'bulan',
        'no_unit',
        'nama_unit',
        'kelompok_unit',
        'biaya_bbm'
    ];
}
