<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfiles';
    
	public function clientes()
    {
      return $this->belongsTo('App\Cliente');
    }
    public function estados()
    {
      return $this->belongsTo('App\Estado');
    }
    public function users()
    {
    	return $this->hasMany('App\PerfilUsuarioCliente');
    }
    public function usersLogins()
    {
        return $this->hasMany('App\UserLogin');
    }

    static function nombreId($registro_id = false)
    {
        if( $registro_id ){
            $data =  Perfil::where('id', $registro_id)->get(['nombre'])->first()->toArray();
            return $data['nombre'];
        }
        return false;
    }

     /**
     * Funcion que permite obtener los perfiles asignados a un usuario de un cliente determinado
     * @param  [type] $user_id    [id del usuario]
     * @param  [type] $cliente_id [id del cliente]
     * @return [type]             [array]
     * @date    Nov 2019
     * @copyright ZonaNube (zonanube.cl)
     * @author Steven Salcedo <ssalcedo@zonanube.cl>
     */
    public static  function perfilClienteUsuario($user_id = null, $cliente_id = null)
    {
        if ( $user_id && $cliente_id ){
            $lista_perfiles     =   Perfil::select([
                    'perfiles.id',
                    'perfiles.nombre'
                ])
                ->join('users', 'users.perfil_id', 'perfiles.id')
                ->where('users.id', $user_id)
                ->where('perfiles.estado_id', 1)
                ->get()->toArray();

            return $lista_perfiles;
        }
        return false;
    }

    public static  function InfoperfilClienteUsuario($user_id = null, $cliente_id = null)
    {
        if ( $user_id && $cliente_id ){
            $lista_perfiles     =   Perfil::
                join('perfil_usuario_clientes', 'perfiles.id', 'perfil_usuario_clientes.perfil_id')
                ->where('perfiles.estado_id', 1)
                ->where('perfil_usuario_clientes.estado_id', 1)
                ->where('perfil_usuario_clientes.cliente_id', $cliente_id)
                ->where('perfil_usuario_clientes.user_id', $user_id)
                ->get([
                    'perfiles.id',
                    'perfiles.nombre',
                ])->toArray();

            return $lista_perfiles;
        }
        return false;
    }
     /**
     * Funcion que permite obtener los perfiles asignados a un usuario de un cliente determinado
     * @param  [type] $user_id    [id del usuario]
     * @param  [type] $cliente_id [id del cliente]
     * @return [type]             [array]
     * @date    Nov 2019
     * @copyright ZonaNube (zonanube.cl)
     * @author Steven Salcedo <ssalcedo@zonanube.cl>
     */
    public static  function perfilClienteUsuarioXml($user_id = array(), $cliente_id = null)
    {
        if ( !empty($user_id) && $cliente_id ){
            $condicion_or = false;
            $lista_perfiles     =   Perfil::
                join('perfil_usuario_clientes', 'perfiles.id', 'perfil_usuario_clientes.perfil_id')
                ->join('users', 'users.id', 'perfil_usuario_clientes.user_id')
                ->where('perfiles.estado_id', 1)
                ->where('perfil_usuario_clientes.estado_id', 1)
                ->where('perfil_usuario_clientes.cliente_id', $cliente_id);
                
                $lista_perfiles = $lista_perfiles->get([
                    'users.rut',
                    'perfiles.nombre as perfil_nombre',
                    'perfil_usuario_clientes.revisa_documentacion'
                ])->toArray();
            return $lista_perfiles;
        }
        return false;
    }
     /**
     * Funcion que permite obtener el perfil asignados a un usuario de un cliente determinado
     * @param  [type] $user_id    [id del usuario]
     * @param  [type] $cliente_id [id del cliente]
     * @return [type]             [array]
     * @date    Dic 2019
     * @copyright ZonaNube (zonanube.cl)
     * @author Steven Salcedo <ssalcedo@zonanube.cl>
     */
    public function perfilClienteUsuarioId($user_id = null, $cliente_id = null, $perfil_id = null) 
    {
        if ( $user_id && $cliente_id && $perfil_id){
            $lista_perfiles     =   Perfil::
                join('users', 'perfiles.id', 'users.perfil_id')
                ->join('cliente_users', 'cliente_users.user_id', 'users.id')
                ->where('perfiles.estado_id', 1)
                ->where('users.user_estados_id', 1)
                ->where('cliente_users.cliente_id', $cliente_id)
                ->where('users.id', $user_id)
                ->where('users.perfil_id', $perfil_id)
                ->get([
                    'perfiles.id',
                    'perfiles.nombre'
                ])->toArray();

            return $lista_perfiles;
        }
        return false;
    }
    /**
     * Funcion que permite lista los perfiles disponibles para los clientes, como tambien aquellos perfiles propios de cada cliente
     * @param  [type] $cliente_id [id cliente]
     * @return [array]             [lista con los perfiles disponibles]
     */
    public function perfilesCliente($cliente_id = null)
    {
        if( $cliente_id ){
            return Perfil::select([
                                'perfiles.id',
                                'perfiles.nombre',
                                'perfiles.visualizador',
                                'perfiles.estado_id'
                            ])
                            ->where('perfiles.estado_id', 1)
                            ->orWhere('perfiles.cliente_id', $cliente_id)
                            ->get()
                            ->toArray();
        }
        return false;
    }


    /**
     * Funcion que permite obtener el listados de los perfiles.
     * Este listado será usado en los filtros de las grillas, originalmente en el modulo de MiEmpresa/Usuaruios
     *  @date Agosto 2020
     * @copyright ZonaNube (zonanube.cl)
     * @author Steven Salcedo <ssalcedo@zonanube.cl>
     */
    public static function filtroGrilla($cliente_id)
    {

        $tipo_accion =  Perfil::select(['nombre'])
                        ->where('perfiles.id','<>', 5)
                        ->orWhere('perfiles.cliente_id', $cliente_id)
                        ->orderBy('nombre', 'ASC')
                        ->get()
                        ->toArray();

        $select_accion = ":";

        foreach ($tipo_accion as $key => $value) {
            $select_accion = $select_accion . ";" . cadenaMayuscula($value['nombre']) . ":" . cadenaMayuscula($value['nombre']);
        }

        return $select_accion;
    }
}
