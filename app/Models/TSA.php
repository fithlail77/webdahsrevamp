<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TSA extends Model
{
    use HasFactory;

    protected $table = 'tbltsa';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'tanggal',
        'no_ticket',
        'transportir',
        'nopol',
        'material',
        'satuan',
        'blok',
        'tt',
        'estate',
        'divisi',
        'lahan',
        'bruto',
        'tara',
        'netto'
    ];
}
