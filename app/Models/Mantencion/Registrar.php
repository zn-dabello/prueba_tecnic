<?php

namespace App\Models\Mantencion;

use HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrar extends Model
{
    protected $table = 'mantencion_registro';

    protected $fillable = [
        'fecha_mantencion',
        'numero_equipo',
        'marca_equipo',
        'ubicacion',
        'proveedor',
    ];

    // Relación con la tabla de repuestos
    public function repuestos()
    {
        return $this->hasMany(Repuesto::class, 'mantencion_registro_id');
    }

    public function listaGrilla()
    {
        $datos = Registrar::select([
            'mantencion_registro.id',
            'mantencion_registro.fecha_mantencion',
            'mantencion_registro.numero_equipo',
            'mantencion_registro.marca_equipo',
            'mantencion_registro.ubicacion',
            'mantencion_registro.proveedor',
            'estados.descripcion as estado'
        ])
            ->Join('estados', 'mantencion_registro.estado_id', '=', 'estados.id')
            ->where('estado_id', '>', -1)
            ->orderBy('fecha_mantencion', 'desc')
            ->get();

        return $datos;
    }


    public function infoRegistro($id = null)
    {
        if ($id) {
            return Registrar::select(
                'mantencion_registro.id',
                'mantencion_registro.fecha_mantencion',
                'mantencion_registro.numero_equipo',
                'mantencion_registro.marca_equipo',
                'mantencion_registro.ubicacion',
                'mantencion_registro.proveedor',
                'estados.descripcion as estado'
            )
            ->join('estados', 'mantencion_registro.estado_id', '=', 'estados.id')
            ->where('mantencion_registro.id', $id)
            ->where('mantencion_registro.estado_id', '>', -1)
            ->first()
            ->toArray();
        }

        return false;
    }



    static function selectRepuestos()
    {
        $repuestos = Repuesto::select(['id', 'nombre_repuesto'])
            ->orderBy('nombre_repuesto', 'ASC')
            ->get()
            ->toArray();

        return $repuestos;
    }

   public static function obtenerInformacionXlsx($cliente_id = null, $condiciones = array() )
   {
        if ($cliente_id && !empty($condiciones)) {

            $lista =   Registrar::select([
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
        $data_registro =  Registrar::select(['descripcion'])->where('id', $registro)->first()->toArray();
        return $data_registro['descripcion'];
    }
}
