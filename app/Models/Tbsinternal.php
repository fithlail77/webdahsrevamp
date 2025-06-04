<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Tbsinternal extends Model
{
    use HasFactory, Notifiable, HasUuids;

    protected $fillable = [
        'id',
        'angkutan',
        'notiket',
        'tgltiket',
        'nosptbs',
        'tglsptbs',
        'tglpanen',
        'supir',
        'nopol',
        'jammasuk',
        'jamkeluar',
        'estate',
        'divisi',
        'blok',
        'tt',
        'lahan',
        'jmltandan',
        'brondolan',
        'bruto',
        'tara',
        'netto',
        'grading',
        'netbersih',
        'bjr',
        'sortase',
        'f0',
        'f00',
        'f14',
        'f5',
        'f6',
        'tankos',
        'tkpanjang',
        'grdbrondolan',
        'sampah',
        'kastrasi',
        'noramp',
        'jarak',
        'tarif',
    ];

    public $incrementing = false;
    protected $keyType = 'string';
}
