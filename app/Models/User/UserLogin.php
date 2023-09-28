<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    public function clientes()
    {
      return $this->belongsTo('App\Cliente');
    }
    public function users()
    {
      return $this->belongsTo('App\User');
    }
    public function perfiles()
    {
      return $this->belongsTo('App\Perfil');
    }

     protected $fillable = [
        'user_id', 'cliente_id', 'perfiles_id', 'proveedor_id'
    ];
}
