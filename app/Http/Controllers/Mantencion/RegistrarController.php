<?php

namespace App\Http\Controllers\Mantencion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\MiInstitucion\ValidarDireccionRequest;
use App\Exports\MiInstitucion\Direccion\DireccionExport;
use App\Models\General\Estado;
use App\Models\Historial\HistorialTipoRegistro;
use App\Models\Mantencion\Registrar;
use App\Models\Historial\HistorialAccion;
use Maatwebsite\Excel\Facades\Excel;
use Auth;

class RegistrarController extends Controller
{
    private $registro;
    private $svg_descripcion;
    private $ver;
    private $editar;
    private $borrar;

    public function __construct()
    {
        $this->registro = new Registrar();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $title_section = "Mantencion / Registro";
        $general_messege = false;
        $mensaje = [];
        $error = 0;

        if ( $request->session()->get('general_messege') ){
            $general_messege = true;
            $mensaje = $request->session()->get('mensaje');
            $error = $request->session()->get('error');
        }

        $tipo_registros_historial = HistorialTipoRegistro::filtroGrilla();
        $historial_acciones = accionesFiltroHistorial('Aplicaciones');
        $historial_tipo_modulo = 3;
        $modulo_historial = 'registrarse';
        $link_ayuda = '#';
        $modulo_sistema = 'Mantencion';
        $sub_modulo_sistema = 'Registrar';

        $accesos = session('plataforma.accesos');
        $visualizador_accesos = $accesos[5]['acceso'] == 3 ? 'true' : 'false';

        // Select busqueda estado
        $tipo_estados = Estado::filtroGrilla();

        return view('mantencion/registrar/index', compact('visualizador_accesos', 'tipo_estados', 'title_section', 'general_messege', 'mensaje', 'error', 'tipo_registros_historial', 'historial_acciones', 'historial_tipo_modulo', 'modulo_historial', 'link_ayuda', 'modulo_sistema','sub_modulo_sistema') );
    }

    public function grid(Request $request)
    {
        if ($request->ajax()) {

            $lista =  $this->registro->listaGrilla();
            $this->svg_descripcion = svgIconos("ver-mas");
            $this->ver = svgIconos("ver");
            $this->editar = svgIconos("editar");
            $this->borrar = svgIconos("borrar");

            $datos = $lista->map(function ($registro) {

                $css_color = ($registro->estado_id == 0 ? 'bg-zn-inactivo' : 'bg-zn-activo');

                $registro->borrar = '<span class="icon-borrar-registro" registro=' . $registro->id.' title="Borrar">'.$this->borrar.'</span>';
                $registro->editar = '<span class="icon-editar-registro" registro=' . $registro->id.' title="Editar">'.$this->editar.'</span>';
                $registro->ver = '<span class="icon-ver-registro" registro=' . $registro->id.' title="Ver">'.$this->ver.'</span>';
                $registro->estado_min = $registro->estado;
                $registro->estado = '<div class="zn-estado '.$css_color.'">'.$registro->estado.'</div>';
                $registro->estado_pnt = '<div class="w-3 h-3 justify-center ms-1 '.$css_color.' rounded-full"></div>';

                return $registro;
            });

            return response()->json([
                'page' => 0,
                'rows' => $datos,
                'total' => 0,
                'records' => count($datos)
            ]);
        }
        return false;
    }

    public function create(Request $request)
    {

        $title_section = "Mantención / Registrar";
        $ruta = "mantencion/registrar";
        $metodo = "POST";
        $tipo = "registrar";
        $etiqueta_accion = "Agregar";
        $tipo_registros_historial = HistorialTipoRegistro::filtroGrilla();
        $historial_acciones = accionesFiltroHistorial('Aplicaciones');
        $historial_tipo_modulo = 3;
        $modulo_historial = 'registrarse';
        $link_ayuda = '#';
        $modulo_sistema = 'Mantencion';
        $sub_modulo_sistema = 'Registrar';
        $repuestos = Registrar::selectRepuestos();

        return view('mantencion/registrar/form', compact('repuestos', 'title_section', 'ruta', 'metodo', 'tipo', 'etiqueta_accion', 'tipo_registros_historial', 'historial_acciones', 'historial_tipo_modulo', 'modulo_historial', 'link_ayuda', 'modulo_sistema','sub_modulo_sistema'));

    }

    public function store(ValidarDireccionRequest $request)
    {

        $error = 1; // 1: no es peticion post
        $mensaje = mensajeError('errGuardar');

        DB::beginTransaction();

        try {
            $data_registro = $this->arrayRequestRegistro($request);


            $registro = $this->registro::create($data_registro['mantencion_registro']);

            /** Registro en historial */
            registroHistorialRegistro(1, $registro->id, 3, $registro->descripcion);

            DB::commit();


            $registro = $registro->id;

            $error = 0;
            $mensaje = mensajeSuccess();

        } catch (\Exception $e) {
            DB::rollback();
        }

        return redirect('mantencion/registrarse')->with(['general_messege'=>true, 'mensaje'=>$mensaje, 'error'=>$error]);


    }

    public function show(Request $request, $tipo, $id)
    {

        $title_section = "Mantenciones / Registro";
        $ruta = $tipo == 'actualizar' ? "mantencion/registrar/editar" : "mantencion/registrarse" ;
        $metodo = $tipo == 'actualizar' ? "POST" : '';

        /** Se obtiene la información */
        $info_registro = $this->registro->infoRegistro($id);

        $tipo_registros_historial = HistorialTipoRegistro::filtroGrilla();
        $historial_acciones = accionesFiltroHistorial('Aplicaciones');
        $historial_tipo_modulo = 3;
        $modulo_historial = 'registros';
        $link_ayuda = '#';
        $modulo_sistema = 'Mantencion';
        $sub_modulo_sistema = 'Registrar';

        if ($info_registro['estado_id'] == 1){
            $info_registro['estado'] = "Activo";
            $info_registro['css_estado'] = "bg-zn-activo";
        } else {
            $info_registro['estado'] = "Inactivo";
            $info_registro['css_estado'] = "bg-zn-inactivo";
        }
        $etiqueta_accion = ($tipo == 'actualizar' ? "Editar" : "Ver Información de la ");

        return view('mantencion/registrar/form', compact('tipo', 'title_section', 'info_registro', 'ruta', 'metodo', 'etiqueta_accion', 'tipo_registros_historial', 'historial_acciones', 'historial_tipo_modulo', 'modulo_historial', 'link_ayuda', 'modulo_sistema','sub_modulo_sistema'));

    }


    public function update(ValidarDireccionRequest $request)
    {

        $error = 1;
        $mensaje = mensajeError('errGuardar');

        $data_registro = $this->arrayRequestRegistro($request);
        $id_datos  = $request['idRegistro'];
        $registro = $this->registro::findOrFail($id_datos);

        $cambios = $this->arrayDatosModificados($data_registro['mantencion_registro'], $registro);

        if ($cambios['cambios']) {

            DB::beginTransaction();
            try {
                if (isset($data_registro['mantencion_registro'])){
                    $registro->update($data_registro['mantencion_registro']);
                }

                /** Registro en historial */
                registroHistorialRegistro(3, $id_datos, 3, $registro->descripcion, $cambios);

                $error = 0;
                $mensaje = mensajeSuccess();

                DB::commit();

            } catch (\Exception $e) {
                DB::rollback();
                dd($e);
            }

        }

        return redirect('mantencion/registrarse')->with(['general_messege'=>true, 'mensaje'=>$mensaje, 'error'=>$error]);

    }

    public function destroy(Request $request)
    {


        $error = 1; // 1: no es peticion post
        $data = array(
            'error' => 1,
            'response' => array()
        );

        if ( $request->ajax() ) {

            $error = 0;
            $data['error'] = 1;
            $data['mensaje'] = mensajeError('errBorrar');

            $registro_id = $request['data'];
            $registro = $this->registro::find($registro_id);
            $registro->estado_id = -1;


            DB::beginTransaction();

            try {
                $registro->save();
                /** Registro en historial */
                registroHistorialRegistro(2, $registro_id, 3);
                $data['error'] = 0;
                $data['mensaje'] = mensajeSuccess('succEliminar');

                DB::commit();

            } catch (\Exception $e) {
                DB::rollback();
            }
        }
        else {
            Auth::logout();
        }

        return response()->json([
            'error' => $error,
            'success' => $data
        ]);
    }

    private function arrayRequestRegistro($request)
    {

        if (!isset($request['inputEstado'])){
            $request['inputEstado'] = 1;
        }

        $registro['mantencion_registro'] = array (
            'fecha_mantencion' => $request->fecha_mantencion,
            'numero_equipo' => $request->numero_equipo,
            'marca_equipo' => $request->marca_equipo,
            'ubicacion' => $request->ubicacion,
            'proveedor' => $request->proveedor,
            'estado_id' => $request->estado_id
        );

        return $registro;

    }

    private function arrayDatosModificados($request, $registro)
    {
        $campos = [
            'fecha_mantencion',
            'numero_equipo',
            'marca_equipo',
            'ubicacion',
            'proveedor',
            'estado_id'
        ];
        $campos_label = [7,5];

        $is_cambios  = comprobarCambios($registro->toArray(), $request, $campos, $campos_label);
        $is_cambios['campos'] = nombresRelacionesCambios($is_cambios['campos']);


        return $is_cambios;

    }

    /**
     * Funcion que permite exportar el listado de ingresos, y si es el caso, aplicando los filtros
     * utilizados en la tabla
     * @param  Request $request [description]
     *  @date 16-08-2023
     * @copyright ZonaNube (zonanube.cl)
     * @author Raudely Pimentel <rpimentel@zonanube.com>
     */
    public function exportxlsx(Request $request)
    {
        if( $request->isMethod('post') ){

            $buscar['buscar_descripcion'] = $request->buscar_domicilio;

            $info['cliente_id']     =   session('plataforma.user.cliente.id');
            $info['nombre_user']    =   Auth::user()->nombre.' '. Auth::user()->apellido;
            $info['encargado']         =   session('plataforma.encargado');;
            $info['registrarse']      =   $this->registro::obtenerInformacionXlsx($info['cliente_id'], $buscar);
            $info['filtros']        =   $buscar;
            $nombre_aplicacion = env('APP_NAME') ;
            $fecha = date('d-m-Y H_i') ;
            $nombre_archivo = "{$nombre_aplicacion} - Registrar {$fecha}.xlsx";

            return (new DireccionExport($info))->download($nombre_archivo);

        }else{
            Auth::logout();
            return redirect('/login')->with('error','Error de sesión');
        }
    }
}
