<?php

namespace App\Models\MiInstitucion;

use Illuminate\Database\Eloquent\Model;

class UserEncargaduria extends Model
{
    protected $table = 'user_encargadurias';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
          'descripcion', 'estado_id'
    ];

    static function selectEncargadurias()
    {
 
         $datos = UserEncargaduria::select(
                                 ['user_encargadurias.id',
                                 'user_encargadurias.descripcion'])
                                 ->where('estado_id', '>', -1)
                                 ->orderBy('descripcion', 'ASC')
                                 ->get()
                                 ->toArray();
 
         return $datos;
    } 

    static function getDescripcion( $id = null)
    {
        if ( ! is_null($id) ) {
 
            $datos = UserEncargaduria::select(
                                    ['user_encargadurias.descripcion'])
                                    ->where('estado_id', '>', -1)
                                    ->where('id', $id)
                                    ->get()
                                    ->toArray();

            return $datos;
        } 
        return $id;
    }
}
