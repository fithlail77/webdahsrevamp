<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aresta extends Model
{
    use HasFactory;

    protected $table = 'tblaresta';

    protected $fillable = [
        'estate',
        'divisi',
        'blok',
        'lahan',
        'tahun_tanam',
        'bibit',
        'topografi',
        'jenis_tanah',
        'status',
        'jml_pokok',
        'luas',
        'sph',
    ];
}
