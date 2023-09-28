<?php

namespace App\Models\MiInstitucion;

use Illuminate\Database\Eloquent\Model;

class TipoAcceso extends Model
{
    protected $table = 'tipo_accesos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
          'descripcion', 'estado_id'
    ];

    static function selectTipoAccesos()
    {
 
         $direccion = TipoAcceso::select(
                                 ['id',
                                 'descripcion'])
                                 ->where('estado_id', '>', -1)
                                 ->get()
                                 ->toArray();
 
         return $direccion;
    }
}
