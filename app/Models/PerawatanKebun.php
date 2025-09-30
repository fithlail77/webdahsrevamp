<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerawatanKebun extends Model
{
    use HasFactory;

    protected $table = 'addperawatan';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'tanggal',
        'jenis_perawatan',
        'blok',
        'tahun_tanam',
        'divisi',
        'estate',
        'lahan',
        'hasil',
        'satuan',
        'jml_tenaga',
        'material_1',
        'jumlah_1',
        'satuan_1',
        'material_2',
        'jumlah_2',
        'satuan_2',
        'material_3',
        'jumlah_3',
        'satuan_3',
        'keterangan'
    ];
}
