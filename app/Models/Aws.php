<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aws extends Model
{
    use HasFactory;

    protected $table = 'aws';

    protected $fillable = [
        'time',
        'date',
        'temp',
        'humid',
        'sol_rad',
        'rainfall',
        'air_pres',
        'wind_speed',
        'wind_dir',
        'et',
        'sunshine',
        'index_uv',
        'bulan',
        'tahun',
        'rainfall_2',
        'waktu_hujan',
        'et_2',
        'sunshine_2'
    ];

}
