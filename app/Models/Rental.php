<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $table = 'addrental';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'tanggal',
        'estate',
        'jenis_alat',
        'no_alat',
        'operator',
        'hm_awal',
        'hm_akhir',
        'total_hm',
        'potongan_hm',
        'pembayaran_hm',
        'blok',
        'tahun_tanam',
        'pekerjaan',
        'divisi',
        'kelompok',
        'coa',
        'tarif',
        'bjr',
        'hasil_1',
        'satuan_1',
        'hasil_2',
        'satuan_2',
        'total_biaya',
    ];
}
