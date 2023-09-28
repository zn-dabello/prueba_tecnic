<?php

namespace App\Http\Controllers\Historial;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Historial\HistorialRegistro;
use App\Models\Historial\Historial;
use App\Models\Historial\HistorialCambio;
use App\Models\Historial\HistorialAccion;
use Carbon\Carbon;


class HistorialRegistroController extends Controller
{
    private $historialRegistro;
    private $historial;
    private $historialCambio;
    private $historialAccion;
    private $tipo;
    private $ver;
    private $ver_mas;
    private $modulos_listados = [48, 52, 57, 60];

    public function __construct()
    {
        // Instancia con el modelo de HistorialRegistro
        $this->historialRegistro      = new HistorialRegistro();
        // Instancia con el modelo de Historial
        $this->historial      = new Historial();
        // Instancia con el modelo de HistorialCambio
        $this->historialCambio      = new HistorialCambio();
        // Instancia con el modelo de HistorialAccciones
        $this->historialAccion      = new HistorialAccion();
        $this->ver = svgIconos("ver");
        $this->ver_mas = svgIconos("ver-mas");
    }


    /**
     * [ajaxRequestFormHistorial description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function ajaxRequestFormHistorial(Request $request)
    {
        if ($request->ajax()) {
            $acciones_historial = $this->historialAccion::filtroGrilla();
            return view('historiales.formHistorial', compact(['acciones_historial']));
        }
        return false;
    }

    /**
     * [ajaxRequestHistorial description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function ajaxRequestHistorial(Request $request)
    {
        if ( $request->ajax() ) {

            $cliente_id = session('plataforma.user.cliente.id');
            $historial_completo = $request['todos'];
            $desde = $request['desde'];
            $hasta = $request['hasta'];
            $modulo_historial = $request['modulo_historial'];
            $eliminar_columna_tipo_registro = 0;

            // Arreglo con los modulo que no debe llevar la columna de "tipo Historial"
            $sin_tipo_registro = ['Ficha','Unidades','Subunidades','Zonas','Sucursales','Usuarios','Responsables-pago'];

            if (in_array($modulo_historial, $sin_tipo_registro)) {
                   $eliminar_columna_tipo_registro = 1;
            }

            if ($modulo_historial == 'configuracion_contratos') {
                /**
                 * Corresponde a los tipos de registros del modulo de configuracion contratos
                 * 20: Tipo Documento, 19: Tipo Contratos, 21: Tipo Hitos, 22: Tipo cierre contrato, 38: Rut Mandante
                 * 39: Cuenta Contable, 40: Unidad Negocio, 41: Departamento Solicitante
                 */
                $tipo = [20,19,21,22,38,39,40,41];
            }
            else if ($modulo_historial == 'configuracion_contratistas') {
                /**
                 * Corresponde a los tipos de registros del modulo de configuracion contratistas
                 * 20: Tipo Documento contratista, 19: Tipo Contratista,
                 */
                $tipo = [36,25];
            }
            else if ($modulo_historial == 'configuracion_trabajadores') {
                /**
                 * Corresponde a los tipos de registros del modulo de configuracion trabajadores
                 * 20: Tipo Documento, 32: Nacionalidad, 27: Previsiones, 28: Salud, 29: Mutuales, 30: Nivel Educacional
                 * 31: Sindicato, 33: Cargo, 34: Lugas de Pago
                 */
                $tipo = [37,32,27,28,29,30,31,33,34];
            }
            else{
                $tipo = [$request['tipo']];
            }
            $this->tipo = $tipo[0];

            /** HISTORIAL COMPLETO */
            if ($historial_completo) {
                $info_historial = $this->historial->historialCompleto($cliente_id, $tipo);
            }
            else{
                $info_historial = $this->historial->historialParcial($cliente_id, $tipo, $desde, $hasta);
            }

            $info_historial = $info_historial->map(function ($historial) {

                $historial->registro = htmlspecialchars(strip_tags($historial->registro));

                $historial->fecha = Carbon::parse($historial->fecha)->format('d-m-Y H:i:s');

                $historial->detalle_historial = '-';

                if ($historial->accion == 3) {
                    

                    $historial->detalle_historial = '<i class="zn-sprite ver zn-clickable ico-ver-detalle-historial" historial="'.$historial->id.'" historial_registro="'.$historial->historial_registro_id.'" tiene_listado="'.$historial->tiene_listado.'"  data-toggle="tooltip" data-placement="top" title="Ver">'.$this->ver.'</i>';

                }

                $historial->registro_index = $historial->registro;
                if (mb_strlen($historial->registro) > 45) {

                    $historial->registro = (!empty($historial->registro) ? ' <span class="icon-descripcion zn-clickable" contenido="'.quitarSaltoLinea($historial->registro).'">'.$this->ver_mas.'</span>' . quitarSaltoLinea($historial->registro, 45) : '');
                }
                // registro sin truncar
                else{
                  $historial->registro = quitarSaltoLinea($historial->registro, false, false);
                }

                $historial->realizado = sprintf('%s %s',$historial->nombre_user, $historial->apellido_user);

                if ( in_array( $this->tipo , $this->modulos_listados)) {
                    if (  ! is_null($historial->listado) ) {
                        $datos_listado = explode("-,-", $historial->listado);
                        
                        $historial->sub_registro = $datos_listado[3];
                        $historial->sub_registro_index = $historial->sub_registro;
                        if (mb_strlen($historial->sub_registro) > 45) {

                            $historial->sub_registro = (!empty($historial->sub_registro) ? ' <span class="icon-descripcion zn-clickable" contenido="'.quitarSaltoLinea($historial->sub_registro).'">'.$this->ver_mas.'</span>' . quitarSaltoLinea($historial->sub_registro, 45) : '');
                        }

                        $historial->sub_tipo = $datos_listado[4];
                        $historial->accion_nombre = $datos_listado[5] . ' ' .$datos_listado[4];
                        if ( in_array($datos_listado[0], [1, 2]) ) {
                            $historial->detalle_historial = '-';
                        } else {
                            $historial->detalle_historial =  '<i class="zn-sprite ver zn-clickable ico-ver-detalle-historial-listado" historial="'.$datos_listado[1].'" historial_registro="'.$datos_listado[2].'"  data-toggle="tooltip" data-placement="top" title="Ver">'.$this->ver.'</i>';
                        }
                    } else {
                        $historial->accion_nombre = $historial->accion_nombre . ' ' . $historial->tipo_registro;
                    }
                }

                return $historial;
            });

            $info_historial = $info_historial->toArray();

            return view('historiales.historial', compact('info_historial', 'eliminar_columna_tipo_registro'));
        }
        else{
            Auth::logout();
        }

    }

    public function ajaxRequestHistorialDetalle(Request $request)
    {
        if ( $request->ajax() ) {

            $historial              =   $request['data']['historial'];
            $historial_registro     =   $request['data']['historial_registro'];
            $tiene_listado          =   $request['data']['tiene_listado'];

            /** HISTORIAL COMPLETO */
            $info_historial_detalle = $this->historialCambio->historialDetalle($historial, $historial_registro, $tiene_listado);

            foreach ($info_historial_detalle['listado'] as $key1 => $detalle) {

                if ( !empty($detalle['historial'])) {

                    foreach ($detalle['historial'] as $key2 => $historial) {
                        // code...
                        if ($historial['historial_accion_id'] == 3) {

                            $info_historial_detalle['listado'][$key1]['historial'][$key2]['detalle'] = '<i class="zn-sprite ver zn-clickable ico-ver-detalle-historial-listado" historial="'.$historial['id'].'" historial_registro="'.$historial['historial_registro_listado_id'].'"  data-toggle="tooltip" data-placement="top" title="Ver">'.$this->ver.'</i>';

                        } 
                        else {
                            $info_historial_detalle['listado'][$key1]['historial'][$key2]['detalle'] = "-";
                        }
                        
                    }

                }
            }

            return view('historiales.historialDetalle', compact('info_historial_detalle'));
        }
        else{
            Auth::logout();
        }
    }

    public function ajaxRequestHistorialDetalleListado(Request $request)
    {
        if ( $request->ajax() ) {

            $historial              =   $request['historial'];
            $historial_registro     =   $request['historial_registro'];
            $tiene_listado          =   $request['tiene_listado'];

            /** HISTORIAL COMPLETO */
            $info_historial_detalle = $this->historialCambio->historialDetalleListado($historial, $historial_registro, $tiene_listado);

            foreach ($info_historial_detalle['listado'] as $key1 => $detalle) {

                if ( !empty($detalle['historial'])) {

                    foreach ($detalle['historial'] as $key2 => $historial) {
                        // code...
                        if ($historial['historial_accion_id'] == 3) {

                            $info_historial_detalle['listado'][$key1]['historial'][$key2]['detalle'] = '<i class="zn-sprite ver zn-clickable ico-ver-detalle-historial-listado" historial="'.$historial['id'].'" historial_registro="'.$historial['historial_registro_listado_id'].'"  data-toggle="tooltip" data-placement="top" title="Ver">'.$this->ver_mas.'</i>';

                        } 
                        else {
                            $info_historial_detalle['listado'][$key1]['historial'][$key2]['detalle'] = "-";
                        }
                        
                    }

                }
            }

            return view('historiales.historialDetalleListado', compact('info_historial_detalle'));
        }
        else{
            Auth::logout();
        }
    }
}