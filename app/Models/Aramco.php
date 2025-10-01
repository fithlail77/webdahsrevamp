<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aramco extends Model
{
    use HasFactory;

    protected $table = 'tblaramco';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'tanggal_rakit',
        'tanggal_pasang',
        'no_po',
        'ukuran',
        'jumlah',
        'satuan',
        'blok',
        'estate',
        'divisi',
        'kordinat',
        'tahun_tanam',
        'lahan',
        'status'
    ];
}
