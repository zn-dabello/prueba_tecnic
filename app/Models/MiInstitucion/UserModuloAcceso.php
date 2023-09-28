<?php

namespace App\Models\MiInstitucion;

use Illuminate\Database\Eloquent\Model;

class UserModuloAcceso extends Model
{
    protected $table = 'user_modulo_accesos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
          'user_id', 'modulo_id', 'tipo_acceso_id'
    ];

    protected $hidden = [
      'created_at', 'updated_at'
    ];


    static function selectModuloAccesos( $id = null )
    {
        if ( ! is_null( $id ) ) {
            $accesos = UserModuloAcceso::select(
                                    ['user_modulo_accesos.id',
                                    'user_modulo_accesos.user_id',
                                    'user_modulo_accesos.modulo_id',
                                    'user_modulo_accesos.tipo_acceso_id AS tipo',
                                    'tipo_accesos.descripcion AS dsc_tipo',
                                    'modulos.descripcion AS modulo'])
                                    ->join('modulos', 'user_modulo_accesos.modulo_id','modulos.id')
                                    ->join('tipo_accesos', 'user_modulo_accesos.tipo_acceso_id','tipo_accesos.id')
                                    ->where('user_id', $id)
                                    ->where('modulos.tipo_modulo', 1)
                                    ->orderBy('modulos.descripcion', 'ASC')
                                    ->get()
                                    ->toArray();
    
            return $accesos;
        }
        return null;
    }

    static function selectSubModuloAccesos( $id = null )
    {
        if ( ! is_null( $id ) ) {
            $accesos = UserModuloAcceso::select(
                                    ['user_modulo_accesos.id',
                                    'user_modulo_accesos.user_id',
                                    'user_modulo_accesos.modulo_id',
                                    'user_modulo_accesos.tipo_acceso_id AS tipo',
                                    'tipo_accesos.descripcion AS dsc_tipo',
                                    'modulos.descripcion AS modulo',
                                    'modulos.modulo_padre AS padre'])
                                    ->join('modulos', 'user_modulo_accesos.modulo_id','modulos.id')
                                    ->join('tipo_accesos', 'user_modulo_accesos.tipo_acceso_id','tipo_accesos.id')
                                    ->where('user_id', $id)
                                    ->where('modulos.tipo_modulo', 2)
                                    ->orderBy('modulos.descripcion', 'ASC')
                                    ->get()
                                    ->toArray();
    
            return $accesos;
        }
        return null;
    }

    static function accesosUsuarioSesion( $id = null )
    {
        if ( ! is_null( $id ) ) {
            $accesos = UserModuloAcceso::select(
                                    [
                                        'user_modulo_accesos.modulo_id',
                                        'user_modulo_accesos.tipo_acceso_id AS acceso',
                                        'modulos.modulo_padre AS padre',
                                        'modulos.descripcion AS modulo'
                                    ])
                                    ->join('modulos', 'user_modulo_accesos.modulo_id','modulos.id')
                                    ->join('tipo_accesos', 'user_modulo_accesos.tipo_acceso_id','tipo_accesos.id')
                                    ->where('user_id', $id)
                                    ->orderBy('modulos.descripcion', 'ASC')
                                    ->get()
                                    ->toArray();
            $array_accesos = [];

            foreach ($accesos as $acceso) {
                $array_accesos[$acceso['modulo_id']]['modulo'] = $acceso['modulo'];
                $array_accesos[$acceso['modulo_id']]['acceso'] = $acceso['acceso'];
                $array_accesos[$acceso['modulo_id']]['padre'] = $acceso['padre'];
            }
    
            return $array_accesos;
        }
        return null;
    }
}
