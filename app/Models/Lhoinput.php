<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lhoinput extends Model
{
    use HasFactory;

    protected $table = 'input';

    protected $fillable = [
        'tgl',
        'hari',
        'bulan',
        'no_unit',
        'nama_unit',
        'kelompok_unit',
        'nik',
        'nama_operator',
        'jam_awal',
        'jam_akhir',
        'total_jam',
        'hm_awal',
        'hm_akhir',
        'hm',
        'blok',
        'estate',
        'divisi',
        'aktivitas',
        'detail_kerja_old',
        'jenis_kerja_old',
        'kelompok_old',
        'hasil',
        'sat',
        'ket',
        'hk',
        'hk2',
        'rp_per_hm',
        'total_biaya',
        'pengguna',
        'detail_kerja',
        'jenis_kerja',
        'kelompok_kerja',
        'kelompok_hm',
        'hm_kerja',
        'hm_travel',
        'jam_standby',
        'jam_service',
        'total_hm',
        'muatan',
        'sat_2',
    ];
}
