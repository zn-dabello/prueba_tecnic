<?php

namespace App\Models\Historial;

use Illuminate\Database\Eloquent\Model;

class HistorialListadoCambio extends Model
{
  protected $table = 'historial_listado_cambios';
	protected $fillable = [
        'historial_listado_id',  'historial_label_id', 'anterior', 'nuevo'
    ];

    public function hitorialListado()
    {
      return $this->belongsTo('App\HistorialListado');
    }
    public function historialLabel()
    {
      return $this->belongsTo('App\HistorialLabel');
    }
}
