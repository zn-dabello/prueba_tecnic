<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ClienteUser extends Model
{
    public function clientes()
    {
      return $this->belongsTo('App\Models\General\Cliente');
    }
    public function users()
    {
      return $this->belongsTo('App\Models\User\User');
    }

    protected $fillable = [
        'user_id', 'cliente_id', 'estado_id'
    ];
}
