<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirSungai extends Model
{
    use HasFactory;

    protected $table = 'air_sungais';

    protected $fillable = [
        'tanggal',
        'pagi_m',
        'sore_m',
        'rataan',
    ];
}
