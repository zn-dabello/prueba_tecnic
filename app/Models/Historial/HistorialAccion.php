<?php

namespace App\Models\Historial;

use Illuminate\Database\Eloquent\Model;

class HistorialAccion extends Model
{
    protected $table = 'historial_acciones';
    //

    public static function filtroGrilla()
    {

        $tipo_accion =  HistorialAccion::select(['historial_acciones.descripcion AS descripcion'])
                                                ->join('historiales', 'historiales.historial_accion_id', 'historial_acciones.id')
                                                ->distinct()
                                                ->orderBy('historial_acciones.descripcion', 'ASC')
                                                ->get()
                                                ->toArray();
        $select_accion = ":";
        foreach ($tipo_accion as $key => $value) {
            $select_accion = $select_accion . ";" . $value['descripcion'] . ":" . $value['descripcion'];
        }

        return $select_accion;
    }
}
