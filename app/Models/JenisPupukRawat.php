<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPupukRawat extends Model
{
    use HasFactory;

    protected $table='tbljenispupukrawat';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'pupuk',
        'rawat'
    ];
}
