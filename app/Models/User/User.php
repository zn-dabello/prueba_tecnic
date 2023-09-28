<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

use App\Models\User\Perfil;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'usuario', 'apellido', 'rut', 'email', 'password', 'cliente_id', 'cargo', 'telefono', 'user_estado_id', 'direccion_id', 'unidad_id', 'subdireccion_id', 'encargaduria_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function fullName()
    {
      return $this->nombre . ' ' . $this->apellido;
    }


    /**
      * Funcion que permite obtener el listado los usuarios con su informacion correspondiente, de un
      * cliente determinado.
    * IMPORTATE: Este listado es utilizado en tabla con JQGrid 5
      * @param [type] $[cliente_id] [Identificador ID del cliente]
      * @return [array] [lista con los usuarios del cliente]
      * @date    Ene 2020
    * @copyright ZonaNube (zonanube.cl)
    * @author Steven Salcedo <ssalcedo@zonanube.cl>
    *  @modified Steven Salcedo <ssalcedo@zonanube.cl>
    *           Jun 2020
    *           Se quita las columas para la tabla JQgrid, con el fin de que la funcion quede
    *           disponible para otros procesos
      */
     public function listaGrilla()
     {
        $usuarios  =   User::select([
                          'users.id',
                          'users.nombre',
                          'users.apellido',
                          'users.usuario',
                          'users.email AS correo',
                          'users.user_estado_id AS estado_id',
                          'user_estados.descripcion as estado',
                          'perfiles.nombre as perfil',
                          'users.bloqueado'
                          ])
                        ->join('user_estados', 'user_estados.id','users.user_estado_id')
                        ->join('perfiles', 'perfiles.id', 'users.perfil_id')
                        ->where('user_estado_id', '>', -1)
                        ->orderby('nombre')
                        ->get();

        return $usuarios;
     }
     /**
      * Funcion que permite obtener la informacion del usuario por su rut
      * @param  boolean $rut_user [description]
      * @return [type]            [description]
      */
    public function infoUserByRut($rut_user = false)
    {
        if ($rut_user){
            $user      =    User::where('users.rut', $rut_user)->get()->first();
            return ($user);
        }
        return false;
    }
    
   /**
    * Funcion que permite obtener la información de un usuario determinada por su ID
    * @param  [type] $user_id [ID de usuario]
    * @return [type]          [arraglo con la informacion del usuario]
    * @date  Mar 2020
    * @copyright ZonaNube (zonanube.cl)
    * @author Steven Salcedo <ssalcedo@zonanube.cl>
    */
   public static  function getUserId($user_id = null)
   {
    if( $user_id ){

        return User::select([
                      'users.id as id',
                      'users.usuario',
                      'perfiles.id AS perfil_id',
                      'perfiles.nombre AS perfil',
                      'users.nombre',
                      'users.apellido',
                      'users.email',
                      'users.user_estado_id',
                      'user_estados.descripcion as estado',
                      'users.recibir_correo_id'
                    ])
                    ->where('users.id', $user_id)
                    ->join('user_estados', 'user_estados.id','users.user_estado_id')
                    ->join('perfiles', 'perfiles.id','users.perfil_id')
                    ->where('user_estado_id', '>', -1)
                    ->get()
                    ->first();
    }
    return false;
   }

   /**
    * Funcion que permite obtener la información de un usuario determinada por su EMAIL
    * @param  [type] $email_user [Email de usuario]
    * @return [type]          [arraglo con la informacion del usuario]
    * @date Agosto 2020
    * @copyright ZonaNube (zonanube.cl)
    * @author Steven Salcedo <ssalcedo@zonanube.cl>
    */
   public static  function getUserEmail($user = null)
   {
    if( $user ){

        return User::select(['users.id', 'users.nombre', 'users.apellido', 'users.email'])
                ->leftjoin('cliente_users', 'users.id', 'cliente_users.user_id')
                ->where('cliente_users.estado_id', '>', 0)
                ->where('users.user_estado_id', '!=', -1)
                ->where(function($query) use ($user) {
                    $query->where('usuario', $user)
                          ->orWhere('email', $user);
                })
                ->get()
                ->first();
    }
    return false;
   }

   /**
    * Funcion que permite obtener el listado de los usuarios para exportar excel
    * @param  [type] $user_id [ID de usuario]
    * @return [type]          [arraglo con la informacion del usuario]
    * @date  Mar 2020
    * @copyright ZonaNube (zonanube.cl)
    * @author Steven Salcedo <ssalcedo@zonanube.cl>
    */
   public function obtenerUserssXlsx($cliente_id = null, $condiciones = array() )
   {
      if ($cliente_id && !empty($condiciones)) {

        $lista_usuarios =   User::select([
                                    'user_estados.descripcion as estado',
                                    'users.email',
                                    'users.usuario',
                                    'users.nombre',
                                    'users.apellido',
                                    'perfiles.nombre as perfil',
                                    'users.recibir_correo_id AS subir'
                                  ])
                                  ->join('user_estados', 'user_estados.id', 'users.user_estado_id')
                                  ->join('perfiles', 'perfiles.id', 'users.perfil_id')
                                  ->where('users.user_estado_id', '>', -1);

                                    if (! empty($condiciones['buscar_nombre_user'])) {
                                      $lista_usuarios = $lista_usuarios->where('users.nombre', 'like', '%' . $condiciones['buscar_nombre_user'] . '%');
                                    }

                                    if (! empty($condiciones['buscar_email_user'])) {
                                      $lista_usuarios = $lista_usuarios->where('users.email', 'like', '%' . $condiciones['buscar_email_user'] . '%');
                                    }

                                    if (! empty($condiciones['buscar_perfil_user'])) {
                                      $lista_usuarios = $lista_usuarios->where('perfiles.nombre', 'like', '%' . $condiciones['buscar_perfil_user'] . '%');
                                    }

                                    if (! empty($condiciones['buscar_estado_user'])) {
                                      $lista_usuarios = $lista_usuarios->where('user_estados.descripcion', 'like', '%' . $condiciones['buscar_estado_user'] . '%');
                                    }

                                  $lista_usuarios = $lista_usuarios->get();
        return $lista_usuarios;

      }
      return false;
   }
   
   /**
    * Funcion que permite validar su in e-mail ya esta registrado para un cliente determinado
    * @param  boolean $email_registro [e-mail ingresado]
    * @param  boolean $cliente_id     [ID cliente]
    * @return [type]                  [true / false]
    *  @date  Mayo 2020
    * @copyright ZonaNube (zonanube.cl)
    * @author Steven Salcedo <ssalcedo@zonanube.cl>
    */
   public function validarExistenciaEmail($email_registro = false, $cliente_id = false, $id_usuario = false)
   {

      if( $email_registro ){

        $user_registrado = User::select(['users.id'])
                                  ->where('users.email', $email_registro)
                                  ->where('users.cliente_id', $cliente_id)
                                  ->where('users.user_estado_id', '!=', -1);
                                  if ( $id_usuario ) {
                                    $user_registrado =  $user_registrado->where('users.id', '!=', $id_usuario);
                                  }
        $user_registrado =  $user_registrado->get()
                            ->first();

        return empty($user_registrado) ? false : true;

      }
      return false;
   }

   public function validarExistenciaUsuario($usuario_registro = false, $cliente_id = false, $id_usuario = false)
   {
      if( $usuario_registro ){

        $user_registrado = User::select(['users.id'])
                                  ->where('users.usuario', $usuario_registro)
                                  ->where('users.cliente_id', $cliente_id)
                                  ->where('users.user_estado_id', '!=', -1);
                                  if ( $id_usuario ) {
                                    $user_registrado =  $user_registrado->where('users.id', '!=', $id_usuario);
                                  }
        $user_registrado =  $user_registrado->get()
                            ->first();
        return empty($user_registrado) ? false : true;

      }
      return false;
   }

   /**
    * Funcion que permite validar si un rut ya esta registrado para un cliente determinado
    * @param  boolean $rut_ingresado [rut ingresado]
    * @param  boolean $cliente_id     [ID cliente]
    * @return [type]                  [true / false]
    *  @date  Mayo 2020
    * @copyright ZonaNube (zonanube.cl)
    * @author Steven Salcedo <ssalcedo@zonanube.cl>
    */
   public function validarExistenciaRut($rut_ingresado = false, $cliente_id = false)
   {
      if( $rut_ingresado ){

        $rut_ingresado           =  mb_ereg_replace("[\|\,\.]",'',$rut_ingresado);
        $rut_ingresado           =  mb_ereg_replace("[\-]",'|',$rut_ingresado);

        $user_registrado = User::select(['users.id'])
                                  ->join('cliente_users', 'cliente_users.user_id', 'users.id')
                                  ->where('users.rut', $rut_ingresado)
                                  ->where('cliente_users.cliente_id', $cliente_id)
                                  ->get()
                                  ->first();
        return empty($user_registrado) ? false : true;

      }
      return false;
   }

 /**
  * Método que permite mostrar los datos de una contraparte especifica
  * @param  Integer $cliente_id     [ID cliente]
  * @param  Integer $rut_ingresado [ID contratista]
  * @return [type]                  [true / false]
  *  @date  Agosto 2020
  * @copyright ZonaNube (zonanube.cl)
  * @author Raudely Pimentel <rpimentel@zonanube.com>
  */

  public function infoRegistro($id = null)
  {
      if($id){

        return User::select(
                      'users.id',
                      'users.email AS correo',
                      'users.nombre',
                      'users.apellido',
                      'user_estados.descripcion as estado',
                      'users.user_estado_id AS estado_id',
                      'user_encargadurias.descripcion AS encargado',
                      'users.encargaduria_id',
                      'users.rut',
                      'users.cargo',
                      'users.telefono',
                      'users.usuario',
                      'sd.descripcion AS subdireccion',
                      'users.subdireccion_id',
                      'd.descripcion AS direccion',
                      'users.direccion_id',
                      'un.descripcion AS unidad',
                      'users.unidad_id')
                  ->join('user_estados', 'user_estados.id', 'users.user_estado_id')
                  ->join('user_encargadurias', 'user_encargadurias.id', 'users.encargaduria_id')
                  ->leftjoin('direcciones AS d', 'd.id', 'users.direccion_id')
                  ->leftjoin('sub_direcciones AS sd', 'sd.id', 'users.subdireccion_id')
                  ->leftjoin('unidades AS un', 'un.id', 'users.unidad_id')
                  ->where('users.id', $id)
                  ->where('users.user_estado_id', '>', -1)
                  ->get()
                  ->first()
                  ->toArray();
      }
  return false;
 }


    static function usuariosContacto() {

        return User::select(
                    'users.email'
                )
                ->where('users.user_estado_id', 1)
                ->where('users.recibir_correo_id', 1)
                ->get();
    }
    
}
