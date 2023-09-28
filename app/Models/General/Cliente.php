<?php

namespace App\Models\General;

use App\Models\User\ClienteUser;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
	public function estados()
    {
      return $this->belongsTo('App\Models\General\Estado');
    }
    public function comunas()
    {
      return $this->belongsTo('App\Models\General\Comuna');
    }
    public function users()
    {
    	return $this->hasMany('App\Models\User\ClienteUser');
    }
    public function perfilUsuarioClientes()
    {
    	return $this->hasMany('App\Models\User\PerfilUsuarioCliente');
    }
    public function usersLogins()
    {
        return $this->hasMany('App\Models\User\UserLogin');
    }
    public function provedores()
    {
        return $this->hasMany('App\Models\User\Proveedor');
    }
    public function zonas()
    {
        return $this->hasMany('App\Models\MiEmpresa\Zona');
    }
    public function clientePagos()
    {
        return $this->hasMany('App\Models\MiEmpresa\ClientePago');
    }


    /**
     * Funcion que permite obtener los clientes activos asignados a un usuarios determiando
     * @param  [type] $usuario_id [identificador del usuario]
     * @return [type]             [array]
     * @date    Nov 2019
     * @copyright ZonaNube (zonanube.cl)
     * @author Steven Salcedo <ssalcedo@zonanube.cl>
     */
    public function clientesActivosUsuario($usuario_id = null)
    {
        if ( $usuario_id ){
            $lista_clientes  =   Cliente::
                select([
                    'clientes.id',
                    'clientes.razon_social',
                    'clientes.nombre_fantasia'
                ])
                ->join('users', 'users.cliente_id', 'clientes.id')
                ->where('clientes.estado_id', 1)
                ->where('users.id', $usuario_id)
                ->distinct()
                ->get()
                ->toArray();

            return $lista_clientes;
         }
         return false;
    }
    /**
     * Funcion que permite obtener la informacion de un cliente determinado
     * @param  [type] $user_id    [id del usuario]
     * @param  [type] $id_cliente [id del cliente]
     * @return [type]             [informacion del cliente]
     * @date    Nov 2019
     * @copyright ZonaNube (zonanube.cl)
     * @author Steven Salcedo <ssalcedo@zonanube.cl>
     */
    public function infoClienteUser($user_id = null, $cliente_id = null)
    {
        if ( $user_id && $cliente_id){

             $cliente_user    =   ClienteUser::
                select(['clientes.id', 'clientes.razon_social', 'clientes.nombre_fantasia'])
                ->join('clientes', 'cliente_users.cliente_id', 'clientes.id')
                ->where([
                    ['cliente_users.user_id','=',$user_id],
                    ['cliente_users.cliente_id','=', $cliente_id],
                    ['cliente_users.estado_id', '=',1]
                ])
                //->get()
                ->first()
                ->toArray();

            return $cliente_user;
        }
        return false;
    }
    /**
     * Funcion que permite obtener la informacion de un cliente determinado
     * @param  [type] $cliente_id [description]
     * @return [type]             [description]
     */
    static public function clienteId($cliente_id = null)
    {
        if( $cliente_id ){
             $info_cliente   =   Cliente::
                                    select(['clientes.id','clientes.rut', 'clientes.nombre_fantasia', 'clientes.razon_social', 'clientes.direccion', 'clientes.telefono', 'clientes.comuna_id', 'comunas.nombre as comuna', 'regiones.nombre as region', 'regiones.numeracion'])
                                    ->join('comunas', 'comunas.id', 'clientes.comuna_id')
                                    ->join('regiones', 'regiones.id', 'comunas.region_id')
                                    ->where('clientes.id',$cliente_id)
                                    //->get()
                                    ->first()
                                    ->toArray();
             return $info_cliente;
        }
        return false;
    }
}
