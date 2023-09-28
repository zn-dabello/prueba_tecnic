<?php

namespace App\Models\Historial;

use Illuminate\Database\Eloquent\Model;

class HistorialTipoRegistro extends Model
{
    protected $table = 'historial_tipo_registros';

    public static function nombreID($listado = false)
    {
    	if( $listado ){
    		return HistorialTipoRegistro::where('historial_tipo_registros.id',$listado)->get(['descripcion'])->first()->toArray();
    	}
    }

    public static function filtroGrilla()
    {

        $tipo_registro =  HistorialTipoRegistro::select(['descripcion'])
                                                ->orderBy('descripcion', 'ASC')
                                                ->get()
                                                ->toArray();
        $select_tipo_registro = ":";
        foreach ($tipo_registro as $key => $value) {
            $select_tipo_registro = $select_tipo_registro . ";" . $value['descripcion'] . ":" . $value['descripcion'];
        }

        return $select_tipo_registro;
    }
}
