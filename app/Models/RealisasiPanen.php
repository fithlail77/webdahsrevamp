<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealisasiPanen extends Model
{
    use HasFactory;

    protected $table = 'realisasi_panen';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'tanggal',
        'jenis_kerja',
        'blok',
        'tt',
        'divisi',
        'estate',
        'hasil',
        'satuan',
        'tk',
        'ha_panen'
    ];
}
