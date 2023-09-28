<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use App\Models\General\Comuna;
use Illuminate\Support\Facades\DB;

class Region extends Model
{
	protected $table = 'regiones';

    public function comunas()
    {
    	return $this->hasMany('App\Region');
    }
    public function unidades()
    {
        return $this->hasMany('App\Unidad');
    }
    /**
     * Funcion que permite obtener el listado de las regiones
     * @return [array] [lista regiones]
     * @date    Dic 2019
     * @copyright ZonaNube (zonanube.cl)
     * @author Steven Salcedo <ssalcedo@zonanube.cl>
     */
    public function listaRegiones()
    {
    	return 		Region::get()->toArray();
    }
     /**
     * Funcion que permite obtener el listado de las comunas donde su nombre haga simulitud con el parametro
     * @param  text     $nombre [cadena de texto con el nombre de la comuna]
     * @return [array]          [lista de comuenas]
     * @date   Mar 2020
     * @copyright ZonaNube (zonanube.cl)
     * @author Steven Salcedo <ssalcedo@zonanube.cl>
     */
    public function infoRegionSimilitudNombre($nombre = false)
    {
        if ( $nombre ){
            return Region::where('nombre', 'like', '%' .$nombre. '%')->get()->toArray();
        }
        return false;
    }
    /**
     * Funcion que permite obtener el nombre una region determinado por su ID
     * @param  text     $nombre [ID Region]
     * @return [array]          [Nombre]
     * @date   Abr 2020
     * @copyright ZonaNube (zonanube.cl)
     * @author Steven Salcedo <ssalcedo@zonanube.cl>
     */
    public static function nombreId($region_id = false)
    {
        if( $region_id ){
            $data_region =  Region::select(['nombre'])->where('id', $region_id)->first()->toArray();
            return $data_region['nombre'];
        }
        return false;
    }


    static function selectRegiones($cliente_id = null)
    {
        if ($cliente_id) {

            $regiones = Region::select(
                                    ['regiones.id',
                                    DB::raw('CONCAT(regiones.numeracion, " - ",regiones.descripcion) AS descripcion')])
                                    ->orderBy('orden', 'ASC')
                                    ->get()
                                    ->toArray();

            return $regiones;

        }

        return false;
    }
}
