<?php

namespace App\Models\MiInstitucion;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = 'modulos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
          'descripcion', 'tipo_modulo', 'estado_id'
    ]; 
}
