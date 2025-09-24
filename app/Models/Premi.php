<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Premi extends Model
{
    use HasFactory;

    protected $table = 'addpremi';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'tanggal',
        'no_kab',
        'nama_kab',
        'nik',
        'nama_karyawan',
        'estate',
        'hmkm_awal',
        'hmkm_akhir',
        'total_hmkm',
        'lokasi',
        'divisi',
        'jenis_pekerjaan',
        'tarif_satuan',
        'hasil_1',
        'satuan_1',
        'hasil_2',
        'satuan_2',
        'total_premi'
    ];
}
