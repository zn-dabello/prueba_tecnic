<?php

namespace App\Models\Historial;

use Illuminate\Database\Eloquent\Model;

class HistorialRegistroListado extends Model
{
    protected $table = 'historial_registro_listados';
	protected $fillable = [
        'descripcion', 'historial_registro_id', 'historial_tipo_registro_id', 'cliente_id'
    ];

	public function clientes()
	{
		return $this->belongsTo('App\Cliente');
	}
	public function historialRegistros()
	{
		return $this->belongsTo('App\HistorialRegistro');
	}
	public function historialTipoRegistros()
	{
		return $this->belongsTo('App\HistorialTipoRegistro');
	}
	public function hisotrialListados()
	{
		return $this->hasMany('App\HistorialListado');
	}
}
