<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pupukrawat extends Model
{
    use HasFactory;

    protected $table = "realisasi_aplikasi_pupuk";

    protected $fillable = [
        'issue_no',
        'material_code',
        'material_name',
        'unit',
        'issue_qty',
        'issue_date',
        'posting_date',
        'storage_location',
        'description',
        'estate',
        'div',
        'block1',
        'block2',
        'years',
        'tm_tbm',
        'sap_issue_no',
        'kelompok',
        'jenis_pupuk',
        'system_aplikasi',
        'bln',
        'tahun',
        'estate2',
        'divisi',
        'status2',
        'areal',
        'blok',
        'tt',
        'programs',
        'dosis',
        'jumlah_pokok',
        'ha',
        'harga',
        'biaya',
    ];
}
