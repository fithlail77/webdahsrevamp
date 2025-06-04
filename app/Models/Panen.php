<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Panen extends Model
{
    use HasFactory, Notifiable, HasUuids;

    protected $fillable = [
        'tanggal',
        'jenispekerjaan',
        'blok',
        'tt',
        'divisi',
        'estate',
        'hasilpanen',
        'satuan',
        'jmltk',
        'hapanen',
    ];

    public $incrementing = false;
    protected $keyType = 'string';
}
