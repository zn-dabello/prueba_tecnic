<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class Comuna extends Model
{
	public function region()
    {
      return $this->belongsTo('App\Region');
    }
    public function clientes()
    {
    	return $this->hasMany('App\Cliente');
    }
    public function zonas()
    {
    	return $this->hasMany('App\Zona');
    }
    public function undiades()
    {
        return $this->hasMany('App\Unidad');
    }
    /**
     * Funcion que permite obtener el listado de las comunas
     * @return [array] [lista comunas]
     * @date    Dic 2019
     * @copyright ZonaNube (zonanube.cl)
     * @author Steven Salcedo <ssalcedo@zonanube.cl>
     */
    public function listaComunas()
    {
    	return 		Comuna::orderBy('nombre', 'asc')->get()->toArray();
    }
    /**
     * Funcion que permite obtener el listado de las comunas donde su nombre haga simulitud con el parametro
     * @param  text     $nombre [cadena de texto con el nombre de la comuna]
     * @return [array]          [lista de comuenas]
     * @date   Mar 2020
     * @copyright ZonaNube (zonanube.cl)
     * @author Steven Salcedo <ssalcedo@zonanube.cl>
     */
    public function infoComunaSimilitudNombre($nombre = false)
    {
        if ( $nombre ){
            return Comuna::where('nombre', 'like', '%' .$nombre. '%')->get()->toArray();
        }
        return false;
    }
    /**
     * Funcion que permite obtener el nombre una comuna determinado por su ID
     * @param  text     $nombre [ID Comuna]
     * @return [array]          [Nombre]
     * @date   Abr 2020
     * @copyright ZonaNube (zonanube.cl)
     * @author Steven Salcedo <ssalcedo@zonanube.cl>
     */
    public static function nombreId($comuna_id = false)
    {
        if( $comuna_id ){
            $data_comuna =  Comuna::select(['nombre'])->where('id', $comuna_id)->first()->toArray();
            return $data_comuna['nombre'];
        }
        return false;
    }


    static function selectComunas($cliente_id = null)
    {
        if ($cliente_id) {

            $comunas = Comuna::select(
                                    ['comunas.id',
                                    'comunas.region_id as relacion',
                                    'comunas.descripcion AS descripcion'])
                                    ->orderBy('descripcion', 'ASC')
                                    ->get()
                                    ->toArray();

            return $comunas;

        }

        return false;
    }
}
