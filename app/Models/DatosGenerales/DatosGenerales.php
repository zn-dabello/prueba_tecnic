<?php

namespace App\Models\DatosGenerales;

use Illuminate\Database\Eloquent\Model;

class DatosGenerales extends Model
{
    protected $fillable = [
        'id',
        'fono_soporte_comercial',
        'email_soporte_comercial',
        'fono_soporte_tecnico',
        'email_soporte_tecnico',
        'direccion',
        'email_de_contacto',
        'fono1',
        'fono2',
        'mapa',
        'archivo',
        'mime',
        'size',
        'binario'
    ];

    protected $table = 'datos_generales';

    public $timestamps = false;
}