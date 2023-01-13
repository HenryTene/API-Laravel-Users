<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PautasInternet extends Model
{
    use HasFactory;

    protected $table = 'pautas_internet';

    protected $fillable = [
        'fec_pauta',
        'des_titular',
        'des_resumen',
        'des_ruta_web',
        'des_ruta_imagen',
        'des_ruta_video'
    ];
}
