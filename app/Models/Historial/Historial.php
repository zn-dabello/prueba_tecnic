<?php

namespace App\Models\Historial;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Historial extends Model
{
    protected $table = 'historiales';
	protected $fillable = [
        'ip',  'user_id', 'cliente_id', 'historial_accion_id', 'historial_registro', 'historial_tipo_registro_id'
    ];
    public function historialRegistros()
	{
		return $this->belongsTo('App\HistorialRegistro');
	}
	public function clientes()
	{
		return $this->belongsTo('App\Cliente');
	}
	public function usuarios()
	{
		return $this->belongsTo('App\User');
	}

	/**
	 * [historialCompleto description]
	 * @param  boolean $cliente_id     [description]
	 * @param  boolean $historial_tipo [description]
	 * @return [type]                  [description]
	 */
	public function historialCompleto($cliente_id = false, $historial_tipo = false)
	{
		if ( $cliente_id && $historial_tipo ){

			return Historial::select([
									'historiales.id', 
									'historiales.historial_accion_id as accion', 
									'historiales.created_at as fecha', 
									'historiales.historial_registro_id', 
									'historial_acciones.descripcion as accion_nombre', 
									'historial_registros.descripcion as registro', 
									'users.nombre as nombre_user', 
									'users.apellido as apellido_user', 
									'historial_tipo_registros.tiene_listado', 
									'historial_tipo_registros.descripcion as tipo_registro', 
									'historial_acciones.detalle as detalle_accion',
			                        DB::raw('(
			                            SELECT 
			                                CONCAT(ha.id, "-,-", hl.id, "-,-", hrl.id, "-,-", hrl.descripcion, "-,-", htr.descripcion, "-,-", ha.descripcion)
			                            FROM historial_listados hl
			                            INNER JOIN historial_registro_listados hrl ON (hrl.id = hl.historial_registro_listado_id)
			                            INNER JOIN historial_tipo_registros htr ON (htr.id = hrl.historial_tipo_registro_id)
			                            INNER JOIN historial_acciones ha ON (ha.id = hl.historial_accion_id)
			                            WHERE
			                                hl.historial_id = historiales.id LIMIT 1) AS listado')])
							->join('historial_registros', 'historial_registros.id', 'historiales.historial_registro_id')
							->join('historial_acciones', 'historial_acciones.id', 'historiales.historial_accion_id')
							->join('users', 'users.id', 'historiales.user_id')
							->join('historial_tipo_registros', 'historial_tipo_registros.id', 'historial_registros.historial_tipo_registro_id')
							->where('historiales.cliente_id',$cliente_id)
							->whereIn('historial_registros.historial_tipo_registro_id',$historial_tipo)
							->orderBy('historiales.created_at', 'DESC')
							->get();
		}

		return false;
	}

	public function historialParcial($cliente_id = false, $historial_tipo = false, $desde = false, $hasta = false)
	{
		if ( $cliente_id && $historial_tipo) {

			return Historial::select([
								'historiales.id', 
								'historiales.historial_accion_id as accion', 
								'historiales.created_at as fecha', 
								'historiales.historial_registro_id', 
								'historial_acciones.descripcion as accion_nombre', 
								'historial_registros.descripcion as registro', 
								'users.nombre as nombre_user', 'users.apellido as apellido_user', 
								'historial_tipo_registros.tiene_listado', 
								'historial_tipo_registros.descripcion as tipo_registro',
		                        DB::raw('(
		                            SELECT 
		                                CONCAT(ha.id, "-,-", hl.id, "-,-", hrl.id, "-,-", hrl.descripcion, "-,-", htr.descripcion, "-,-", ha.descripcion)
		                            FROM historial_listados hl
		                            INNER JOIN historial_registro_listados hrl ON (hrl.id = hl.historial_registro_listado_id)
		                            INNER JOIN historial_tipo_registros htr ON (htr.id = hrl.historial_tipo_registro_id)
		                            INNER JOIN historial_acciones ha ON (ha.id = hl.historial_accion_id)
		                            WHERE
		                                hl.historial_id = historiales.id LIMIT 1) AS listado')])
							->join('historial_registros', 'historial_registros.id', 'historiales.historial_registro_id')
							->join('historial_acciones', 'historial_acciones.id', 'historiales.historial_accion_id')
							->join('users', 'users.id', 'historiales.user_id')
							->join('historial_tipo_registros', 'historial_tipo_registros.id', 'historial_registros.historial_tipo_registro_id')
							->where('historiales.cliente_id',$cliente_id)
							->where('historiales.created_at','>=',date('Y-m-d 00:00:00', strtotime($desde)))
							->where('historiales.created_at','<=',date('Y-m-d 23:59:59', strtotime($hasta)))
							->whereIn('historial_registros.historial_tipo_registro_id',$historial_tipo)
							->orderBy('historiales.created_at', 'DESC')
							->get();
		}

		return false;
	}
}
