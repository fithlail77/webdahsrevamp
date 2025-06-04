<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perawatan extends Model
{
    use HasFactory;

    protected $table = "perawatanku";
    protected $fillable = [
        'tanggal',
        'bulan',
        'tahun_jalan',
        'tahun',
        'nik',
        'nama',
        'status',
        'pembayaran',
        'blok',
        'tt',
        'kelompok',
        'coa',
        'ket',
        'tarif_rp',
        'bjr',
        'hasil',
        'sat',
        'hasil_2',
        'sat_2',
        'total',
        'periode',
        'period_txt',
        'tahun_period',
        'estate',
        'divisi',
        'jenis_pekerjaan',
        'areal',
        'keterangan',
        'sph',
        'ha',
        'hk',
    ];
}
