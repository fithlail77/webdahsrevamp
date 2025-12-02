<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SptbsInput extends Model
{
    use HasFactory;

    protected $table = 'addsptbs';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'angkutan',
        'no_tiket',
        'tanggal_tiket',
        'no_sptbs',
        'tanggal_sptbs',
        'tanggal_panen',
        'nama_supir',
        'no_polisi',
        'jam_masuk',
        'jam_keluar',
        'estate',
        'divisi',
        'blok',
        'tahun_tanam',
        'lahan',
        'jumlah_tandan',
        'berondolan',
        'berat_bruto',
        'berat_tarra',
        'berat_netto',
        'jumlah_grading',
        'berat_bersih',
        'bjr',
        'f00',
        'f0',
        'f14',
        'f5',
        'f6',
        't_kosong',
        'sampah',
        'tangkai_pjg',
        'kastrasi',
    ];
}
