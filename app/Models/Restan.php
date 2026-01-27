<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restan extends Model
{
    use HasFactory;

    protected $table = 'laprestan';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'tanggal',
        'estate',
        'divisi',
        'blok',
        'tonase',
        'keterangan',
        'tt'
    ];
}
