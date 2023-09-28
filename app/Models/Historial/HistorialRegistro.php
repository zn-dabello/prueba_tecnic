<?php

namespace App\Models\Historial;

use Illuminate\Database\Eloquent\Model;

class HistorialRegistro extends Model
{
    protected $table = 'historial_registros';
	protected $fillable = [
        'descripcion', 'historial_registro', 'historial_tipo_registro_id', 'cliente_id'
    ];

	public function clientes()
	{
		return $this->belongsTo('App\Cliente');
	}
	public function historialTipoRegistros()
	{
		return $this->belongsTo('App\HistorialTipoRegistro');
	}
	public function hisotriales()
	{
		return $this->hasMany('App\Historial');
	}

	public function datosHistorialSeeder($tipo)
	{

		if ($tipo) {

			$query  = HistorialRegistro::select(
                ['historial_registros.id',
                'historial_registros.cliente_id',
                'historial_registros.created_at']
                )
                ->where('historial_registros.historial_tipo_registro_id',  $tipo)
                ->get()
                ->toArray();

          return $query;

		}

        return false;
	}

}
