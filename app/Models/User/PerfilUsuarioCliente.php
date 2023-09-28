<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class PerfilUsuarioCliente extends Model
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
    public function estados()
    {
      return $this->belongsTo('App\Estado');
    }
    public function zonas()
    {
      return $this->belongsTo('App\zona');
    }
    protected $fillable = [
        'user_id', 'cliente_id', 'perfiles_id', 'estado_id', 'revisa_documentacion', 'zona_id'
    ];
    /**
     * Funcion que permite obtener la informacion de un perfil determinado
     * @param  [type] $user_id    [id del usuario]
     * @param  [type] $perfil     [id del perfil]
     * @param  [type] $id_cliente [id del cliente]
     * @return [type]             [informacion del perfil]
     * @date    Nov 2019
     * @copyright ZonaNube (zonanube.cl)
     * @author Steven Salcedo <ssalcedo@zonanube.cl>
     */
    public function perfilUser($user_id = null, $perfil = null, $id_cliente = null)
    {
        if ( $user_id && $perfil && $id_cliente){
            $perfil_user    =   PerfilUsuarioCliente::
                join('perfiles', 'perfil_usuario_clientes.perfiles_id', 'perfiles.id')
                ->where([
                    ['perfil_usuario_clientes.user_id','=',$user_id],
                    ['perfil_usuario_clientes.perfiles_id','=', $perfil],
                    ['perfil_usuario_clientes.cliente_id','=', $id_cliente],
                    ['perfil_usuario_clientes.estado_id', '=',1]
                ])
                ->get([
                    'perfiles.id', 'perfiles.nombre', 'perfiles.perfil', 'perfiles.contraparte'
                ])
                ->first()
                ->toArray();

            return $perfil_user;
        }
        return false;
        
    }
}
