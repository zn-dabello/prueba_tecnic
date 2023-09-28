<?php

namespace App\Models\Administracion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use App\Models\User\Perfil;

class Ingreso extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'cliente_id', 'perfiles_id'
    ];

    protected $table = 'user_logins';

    protected $hidden = [
      'created_at', 'updated_at'
    ];

     public function listaIngresosCliente($cliente_id = null)
     {
        if ($cliente_id) {

            $ingresos  =   Ingreso::select([
                              'user_logins.id',
                              DB::raw('CONCAT(users.nombre, " ", users.apellido) AS nombre'),
                              'perfiles.nombre AS perfil',
                              DB::raw('DATE_FORMAT(user_logins.created_at, "%d-%m-%Y %H:%i:%s") AS fecha')
                              ])
                            ->join('users', 'user_logins.user_id','users.id') 
                            ->join('cliente_users', 'cliente_users.user_id','users.id')
                            ->join('perfiles', 'perfiles.id', 'users.perfiles_id')
                            ->where('cliente_users.cliente_id', $cliente_id)
                            ->where('user_estados_id', '>', -1)
                            ->orderby('user_logins.created_at', 'DESC')
                            ->get();

            return $ingresos;
        }

        return false;
     }

   public function obtenerIngresosXlsx($cliente_id = null, $condiciones = array() )
   {
      if ($cliente_id && !empty($condiciones)) {

        $lista_ingresos =   Ingreso::select([
                                    DB::raw('DATE_FORMAT(user_logins.created_at, "%d-%m-%Y %H:%i:%s") AS fecha'),
                                    DB::raw('CONCAT(users.nombre, " ", users.apellido) AS nombre'),
                                    'perfiles.nombre AS perfil'
                                  ])
                                  ->join('users', 'user_logins.user_id','users.id') 
                                  ->join('cliente_users', 'cliente_users.user_id','users.id')
                                  ->join('perfiles', 'perfiles.id', 'users.perfiles_id')
                                  ->where('cliente_users.cliente_id', $cliente_id)
                                  ->where('user_estados_id', '>', -1)
                                  ->orderby('user_logins.created_at', 'DESC');

                                    if (! empty($condiciones['buscar_nombre_ingreso'])) {
                                      $lista_ingresos = $lista_ingresos->where( DB::raw('CONCAT(users.nombre, " ", users.apellido)'), 'like', '%' . $condiciones['buscar_nombre_ingreso'] . '%');
                                    }

                                    if (! empty($condiciones['buscar_perfil_ingreso'])) {
                                      $lista_ingresos = $lista_ingresos->where('perfiles.nombre', 'like', '%' . $condiciones['buscar_perfil_ingreso'] . '%');
                                    }

                                    if (! empty($condiciones['buscar_fecha_ingreso'])) {
                                      $lista_ingresos = $lista_ingresos->where(DB::raw('DATE_FORMAT(user_logins.created_at, "%d-%m-%Y %H:%i:%s")'), 'like', '%' . $condiciones['buscar_fecha_ingreso'] . '%');
                                    }

                                    

                                  $lista_ingresos = $lista_ingresos->get();
        return $lista_ingresos;

      }
      return false;
   }
}
