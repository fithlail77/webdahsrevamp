<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aresta extends Model
{
    use HasFactory;

    protected $table = 'aresta';

    protected $fillable = [
        'bulan',
        'estate',
        'divisi',
        'blok',
        'tahun_tanam',
        'status_tanaman',
        'status_lahan',
        'jenis_bibit',
        'topografi',
        'jenis_tanah',
        'pokok',
        'luas',
        'jenis_input',
    ];
}
