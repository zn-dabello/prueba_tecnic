<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{

    protected $table = 'password_resets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token', 'user_id', 'estado_id', 'code'
    ];

    public function estados()
    {
      return $this->belongsTo('App\Estado');
    }


    /**
    * Funcion que permite Validar si el codigo (code en bbddd) existe
    * @param  text     $nombre [ID estado]
    * @return [array]   
    * @date Agosto 2020
    * @copyright ZonaNube (zonanube.cl)
    * @author Steven Salcedo <ssalcedo@zonanube.cl>
    */
    public static function validarCode($code = false)
    {
        if ($code) {

            $code = PasswordReset::select(['id', 'user_id', 'token', 'estado_id'])->where('code', $code)->first();

            return (! empty($code) ? $code->toArray() : $code);

        }

        return false;
    }


    /**
    * Funcion que permite Validar si el codigo (code en bbddd) esta habilitado
    * @param  text     $nombre [ID estado]
    * @return [array]   
    * @date Agosto 2020
    * @copyright ZonaNube (zonanube.cl)
    * @author Steven Salcedo <ssalcedo@zonanube.cl>
    */
    public static function validarCodeHabilitado($id = false)
    {
        if ($id) {

            $code = PasswordReset::select(['id', 'user_id', 'token', 'estado_id'])->where('id', $id)->where('estado_id', true)->first();

            return (! empty($code) ? true : false);

        }

        return false;
    }
}
