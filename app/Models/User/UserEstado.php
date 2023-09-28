<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class UserEstado extends Authenticatable
{
    use Notifiable;

    protected $table = 'user_estados';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'descripcion'
    ];

    public function usuarios()
    {
        return $this->hasMany('App\Models\User\User');
    }

    /**
    * Funcion que permite obtener el nombre un estado determinado por su ID
    * @param  text     $nombre [ID estado]
    * @return [array]          [Nombre]
    * @date Julio 2020
    * @copyright ZonaNube (zonanube.cl)
    * @author Steven Salcedo <ssalcedo@zonanube.cl>
    */
    public static function nombreId($estado_id = false)
    {
        $estado_id = !$estado_id ? 0 : $estado_id;
        $data_estado =  UserEstado::select(['descripcion'])->where('id', $estado_id)->first()->toArray();
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

        $tipo_accion =  UserEstado::select(['descripcion'])
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
