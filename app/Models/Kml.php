<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kml extends Model
{
    use HasFactory;

    protected $table = 'kml_files';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [ 
        'nama_asisten',
        'estate',
        'divisi',
        'tanggal',
        'name',
        'path',
        'uploaded_at'
    ];
}
