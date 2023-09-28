<?php

namespace App\Models\MiInstitucion;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $table = 'unidades';

    static function selectUnidades()
    {
 
         $select = Unidad::select(
                                 ['unidades.id',
                                 'unidades.descripcion',
                                 'unidades.estado_id',
                                 'unidades.subdireccion_id AS relacion'])
                                 ->where('estado_id', '>', -1)
                                 ->orderBy('descripcion', 'ASC')
                                 ->get()
                                 ->toArray();
 
         return $select;
    }
}
