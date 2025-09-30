<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemupukanKebun extends Model
{
    use HasFactory;

    protected $table = 'addpemupukan';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'tanggal',
        'jenis_pupuk',
        'blok',
        'tahun_tanam',
        'divisi',
        'estate',
        'lahan',
        'hasil',
        'pokok',
        'dosis',
        'jml_tenaga',
        'keterangan'
    ];
}
