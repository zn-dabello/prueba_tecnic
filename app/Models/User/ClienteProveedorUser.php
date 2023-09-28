<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ClienteProveedorUser extends Model
{

    protected $fillable = [
        'user_id', 'cliente_id', 'proveedor_id', 'estado_id'
    ];
    public function clientes()
    {
      return $this->belongsTo('App\Cliente');
    }
    public function users()
    {
      return $this->belongsTo('App\User');
    }
    public function provedores()
    {
      return $this->belongsTo('App\Proveedor');
    }
    public function estados()
    {
      return $this->belongsTo('App\Estado');
    }
}
