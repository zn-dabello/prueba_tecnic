<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estados';

	/**
	* Funcion que permite obtener el nombre un estado determinado por su ID
	* @param  text     $nombre [ID estado]
	* @return [array]          [Nombre]
	* @date   Abr 2020
	* @copyright ZonaNube (zonanube.cl)
	* @author Steven Salcedo <ssalcedo@zonanube.cl>
	*/
	public static function nombreId($estado_id = false)
	{
		$estado_id = !$estado_id ? 0 : $estado_id;
		$data_estado =  Estado::select(['descripcion'])->where('id', $estado_id)->first()->toArray();
		return $data_estado['descripcion'];
	}


    /**
     * Funcion que permite obtener el listados de los estados.
     * Este listado será usado en los filtros de las grillas
     *  @date 10-02-2022
     * @copyright ZonaNube (zonanube.cl)
     * @author Raudely Pimentel <rpimentel@zonanube.com>
     */
    public static function filtroGrilla()
    {

        $tipo_accion =  Estado::select(['descripcion'])
                        ->where('id','<>', -1)
                        ->get()
                        ->toArray();

        $select_accion = ":";

        foreach ($tipo_accion as $key => $value) {
            $select_accion = $select_accion . ";" . cadenaMayuscula($value['descripcion']) . ":" . cadenaMayuscula($value['descripcion']);
        }

        return $select_accion;
    }

}


