<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Menu extends Model
{
    protected $fillable = [
        'cliente_id',
        'id',
        'descripcion',
        'ruta',
        'padre',
        'orden',
        'etiqueta',
        'mis_datos',
        'perfil_id',
        'estado_id',
        'modulo_id'
    ];

    protected $table = 'menus';

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function clientes()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function estados()
    {
        return $this->belongsTo(Estado::class);
    }

    public function perfiles()
    {
        return $this->belongsTo(Perfil::class);
    }

    /**
      * Recorre el array $data para extraer los “hijos” (el valor del campo padre debe coincidir con el id de la opción superior).
      * @param [type] $[data] [Identificador ID del cliente]
      * @param [type] $[linea] [registro]
      * @return [array] [listado con los datos]
      * @date  Agosto 2020
      * @copyright ZonaNube (zonanube.cl)
      * @author Raudely Pimentel <rpimentel@zonanube.com>
      */
    public function getHijo($data, $linea)
    {

        $hijo = [];

        foreach ($data as $linea1) {

            if ($linea['id'] == $linea1['padre']) {
                $hijo = array_merge($hijo, [ array_merge($linea1, ['submenu' => $this->getHijo($data, $linea1) ]) ]);
            }

        }

        return $hijo;
    }


    /**
      * Retorna un array con las opciones del menú activas (estado_id = 1) y ordenadas
      * @param
      * @return [array] [listado con los datos]
      * @date  Agosto 2020
      * @copyright ZonaNube (zonanube.cl)
      * @author Raudely Pimentel <rpimentel@zonanube.com>
      */
    public function opcionesMenu()
    {

        $perfil = Auth::user('attributes')->perfil_id;
        $cliente_id = Auth::user('attributes')->cliente_id;

        return $this->where('estado_id', 1)
            ->where('perfil_id', $perfil)
            ->where('cliente_id', $cliente_id)
            ->orderby('padre')
            ->orderby('orden')
            ->get()
            ->toArray();

    }


    /**
      * recorrer todas las opciones del menú y en aquellas opciones “padre” obtener sus “hijos” u opciones que dependerán de la opción principal, y éste grupo de ítems quedarán registrados en un array llamado submenú
      * @param
      * @return [array] [listado con los datos]
      * @date  Agosto 2020
      * @copyright ZonaNube (zonanube.cl)
      * @author Raudely Pimentel <rpimentel@zonanube.com>
      */
    public static function menus()
    {

        $menus = new Menu();
        $data = $menus->opcionesMenu();
        $menu_total = [];

        foreach ($data as $linea) {

            if($linea['padre']==0){
                $item = [ array_merge($linea, ['submenu' => $menus->getHijo($data, $linea) ]) ];
                $menu_total = array_merge($menu_total, $item);

            }

        }

        return $menus->menu_total = $menu_total;
    }
}
