<?php

namespace App\Models\MiInstitucion;

use Illuminate\Database\Eloquent\Model;

class SubDireccion extends Model
{

    public function direccion()
    {
        return $this->belongsTo(Direccion::class, 'direccion_id');
    }

    protected $table = 'sub_direcciones';
    /**subdirecciones
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'direccion_id', 'descripcion', 'estado_id'
    ];


    protected $hidden = [
      'created_at', 'updated_at'
    ];

    public function listaGrilla()
    {
        $datos = SubDireccion::select([
            'sub_direcciones.id',
            'sub_direcciones.direccion_id',
            'sub_direcciones.descripcion',
            'sub_direcciones.estado_id',
            'estados.descripcion as estado'
        ])
        ->join('estados', 'sub_direcciones.estado_id', '=', 'estados.id')
        ->where('estado_id', '>', -1)
        ->orderBy('descripcion')
        ->get();

        return $datos;
    }

    public function infoRegistro($id = null)
    {
        if ($id) {
            return SubDireccion::select(
                'sub_direcciones.id',
                'sub_direcciones.direccion_id',
                'sub_direcciones.descripcion',
                'sub_direcciones.estado_id',
                'estados.descripcion as estado'
            )
            ->join('estados', 'sub_direcciones.estado_id', '=', 'estados.id')
            ->where('sub_direcciones.id', $id)
            ->where('sub_direcciones.estado_id', '>', -1)
            ->get()
            ->first()
            ->toArray();
        }
        return false;
    }


   static function selectSubDirecciones()
   {
       $direcciones = SubDireccion::select(
           ['sub_direcciones.id',
           'sub_direcciones.descripcion',
           'sub_direcciones.direccion_id AS relacion']
       )
       ->where('estado_id', '>', -1)
       ->orderBy('descripcion', 'ASC')
       ->get()
       ->toArray();

       return $direcciones;
   }


   public static function obtenerInformacionXlsx($cliente_id = null, $condiciones = array())
   {
       if ($cliente_id && !empty($condiciones)) {
           $lista = SubDireccion::select([
               'sub_direcciones.direccion_id',
               'sub_direcciones.descripcion',
               'sub_direcciones.estado_id',
           ])
           ->join('estados', 'sub_direcciones.estado_id', 'estados.id')
           ->where('sub_direcciones.estado_id', '>', -1)
           ->orderBy('sub_direcciones.descripcion');

           if (!empty($condiciones['buscar_descripcion'])) {
               $lista = $lista->where('sub_direcciones.descripcion', 'like', '%' . $condiciones['buscar_descripcion'] . '%');
           }

           return $lista->get();
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
       $data_registro =  SubDireccion::select(['descripcion'])->where('id', $registro)->first()->toArray();
       return $data_registro['descripcion'];
   }

}
