<?php

namespace App\Models\Mantencion;

use Illuminate\Database\Eloquent\Model;

class Repuesto extends Model
{
    protected $table = 'repuestos';

    protected $fillable = [
        'mantencion_registro_id',
        'nombre_repuesto',
        'cantidad',
    ];


}
