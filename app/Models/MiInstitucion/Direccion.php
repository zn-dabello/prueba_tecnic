<?php

namespace App\Models\MiInstitucion;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table = 'direcciones';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
          'descripcion', 'estado_id'
    ];

    protected $hidden = [
      'created_at', 'updated_at'
    ];

    public function listaGrilla()
    {

        $datos  =   Direccion::select([
                            'direcciones.id',
                            'direcciones.descripcion',
                            'direcciones.estado_id',
                            'estados.descripcion as estado'
                            ])
                        ->join('estados', 'direcciones.estado_id', '=', 'estados.id')
                        ->where('estado_id', '>', -1)
                        ->orderby('descripcion')
                        ->get();

        return $datos;
    }

    public function infoRegistro($id = null)
    {
        if($id){

            return Direccion::select(
                        'direcciones.id',
                        'direcciones.descripcion',
                        'direcciones.estado_id',
                        'estados.descripcion as estado')
                    ->join('estados', 'direcciones.estado_id', '=', 'estados.id')
                    ->where('direcciones.id', $id)
                    ->where('direcciones.estado_id', '>', -1)
                    ->get()
                    ->first()
                    ->toArray();
        }
    return false;
   }


   static function selectDirecciones()
   {

        $direccion = Direccion::select(
                                ['direcciones.id',
                                'direcciones.descripcion',
                                'direcciones.estado_id'])
                                ->where('estado_id', '>', -1)
                                ->orderBy('descripcion', 'ASC')
                                ->get()
                                ->toArray();

        return $direccion;
   }

   public static function obtenerInformacionXlsx($cliente_id = null, $condiciones = array() )
   {
        if ($cliente_id && !empty($condiciones)) {

            $lista =   Direccion::select([
                                   'estados.descripcion AS estado',
                                   'direcciones.descripcion'
                                    ])
                               ->join('estados', 'direcciones.estado_id','estados.id')
                               ->where('direcciones.estado_id', '>', -1)
                               ->orderby('direcciones.descripcion');

                               if (! empty($condiciones['buscar_descripcion'])) {
                                   $lista = $lista->where( 'direcciones.descripcion', 'like', '%' . $condiciones['buscar_descripcion'] . '%');
                               }

                               $lista = $lista->get();
       return $lista;

        }
    }

    /**
    * Funcion que permite obtener el nombre un estado determinado por su ID
    * @param  text     $nombre [ID estado]
    * @return [array]          [Nombre]
    * @date   05-09-2023
    * @copyright ZonaNube (zonanube.cl)
    * @author Raudely Pimentel <rpimentel@zonanube.com>
    */
    public static function nombreId($registro = false)
    {
        $registro = !$registro ? 0 : $registro;
        $data_registro =  Direccion::select(['descripcion'])->where('id', $registro)->first()->toArray();
        return $data_registro['descripcion'];
    }
}
