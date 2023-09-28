<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'paises';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'estado_id', 'descripcion', 'codigo', 'orden'
    ];

    protected $hidden = [
      'created_at', 'updated_at'
    ];

    public function estados()
    {
        return $this->belongsTo(Estado::class);
    }

    public function proveedores()
    {
        return $this->hasMany(Proveedor::class);
    }


    static function selectPaises($cliente_id = null)
    {
        if ($cliente_id) {

            $paises = Pais::select(
                                    ['paises.id',
                                    'paises.descripcion AS descripcion'])
                                    ->where('estado_id', 1)
                                    ->where('orden', -1)
                                    ->orderBy('orden', 'ASC')
                                    ->get()
                                    ->toArray();

            return $paises;

        }

        return false;
    }
}
