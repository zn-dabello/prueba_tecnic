<?php

namespace App\Models\MiInstitucion;

use Illuminate\Database\Eloquent\Model;

class Submodulo extends Model
{
    protected $table = 'submodulos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
          'descripcion', 'estado_id', 'modulo_id'
    ];
}
