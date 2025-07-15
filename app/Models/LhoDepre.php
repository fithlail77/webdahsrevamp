<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LhoDepre extends Model
{
    use HasFactory;

    protected $table = 'depreciation';

    protected $fillable = [
        'no_unit',
        'nama_unit',
        'aset',
        'cap_on',
        'aset_desc',
        'acq_val',
        'bulan',
        'depre'
    ];
}
