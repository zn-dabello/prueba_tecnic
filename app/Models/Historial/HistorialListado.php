<?php

namespace App\Models\Historial;

use Illuminate\Database\Eloquent\Model;

class HistorialListado extends Model
{
    protected $table = 'historial_listados';
	protected $fillable = [
        'ip', 'cliente_id', 'historial_accion_id', 'historial_registro_listado_id', 'historial_tipo_registro_id'
    ];
    public function historialRegistroListados()
	{
		return $this->belongsTo('App\HistorialRegistroListado');
	}
	public function clientes()
	{
		return $this->belongsTo('App\Cliente');
	}
	public function usuarios()
	{
		return $this->belongsTo('App\User');
	}

	public static function historial($historial_registro = false, $listado = false, $historial = false)
	{
		// 
		if ( $historial_registro && $listado ){

			$listado_detalle = HistorialListado::join('historial_registro_listados', 'historial_registro_listados.id', 'historial_listados.historial_registro_listado_id')
									->join('historial_acciones', 'historial_acciones.id', 'historial_listados.historial_accion_id')
									->join('historial_tipo_registros', 'historial_tipo_registros.id', 'historial_registro_listados.historial_tipo_registro_id')
									->where('historial_registro_listados.cliente_id',session('plataforma.user.cliente.id'))
									->where('historial_registro_listados.historial_registro_id',$historial_registro)
									->where('historial_registro_listados.historial_tipo_registro_id',$listado);
			
			if ( $historial ) {
				$listado_detalle = $listado_detalle->where('historial_id', $historial);
			}
			
			$listado_detalle = $listado_detalle->get(['historial_listados.id', 'historial_listados.historial_accion_id as accion', 'historial_listados.created_at as fecha', 'historial_listados.historial_registro_listado_id', 'historial_acciones.descripcion as accion_nombre', 'historial_registro_listados.descripcion as registro', 'historial_accion_id', 'historial_tipo_registros.descripcion as descripcion']);
									

			return $listado_detalle;
		}
	}
}
