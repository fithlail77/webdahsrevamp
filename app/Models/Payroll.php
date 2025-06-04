<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $table = "payroll";

    protected $fillable = [
        'estate',
        'tanggal',
        'periode',
        'tahun',
        'divisi',
        'nik',
        'nama',
        'status',
        'pembayaran',
        'blok',
        'tahun_tanam',
        'jenis_pekerjaan',
        'divisi_2',
        'kelompok',
        'coa',
        'ket',
        't_rp',
        'jjg',
        'hasil',
        'sat',
        'hasil_2',
        'sat_21',
        'total',
        'jenis_pupuk',
        'jm_1',
        'qty_1',
        'sat_1',
        'jm_2',
        'qty_2',
        'sat_2',
        'jm_3',
        'qty_3',
        'sat_3',
        'nik_mandor',
        'nama_mandor',
        'hk',
        'hk1',
    ];
}
