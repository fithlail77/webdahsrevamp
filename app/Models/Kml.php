<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kml extends Model
{
    use HasFactory;

    protected $table = 'kml_files';
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

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
