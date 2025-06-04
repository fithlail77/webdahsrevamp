<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class CurahHujan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pt',
        'dates',
        'estate',
        'divisi',
        'ch',
    ];
}
