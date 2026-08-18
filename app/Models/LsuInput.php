<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LsuInput extends Model
{
    use HasFactory;

    protected $table = 'lsu_rev';

    protected $fillable = [
        'tahun',
        'blok',
        'estate',
        'divisi',
        'tahun_tanam',
        'blok_tt',
        'luas',
        'pokok',
        'lsu',
        'unsur_hara',
        ];
}
