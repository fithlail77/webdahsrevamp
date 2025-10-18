<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlokKordinat extends Model
{
    use HasFactory;
    
    protected $table = 'tblblokkordinat';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'estate',
        'divisi',
        'blok',
        'x',
        'y',
        'l1',
        'l2',
        'poly_id'
    ];
}
