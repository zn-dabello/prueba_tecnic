<?php

namespace App\Http\Controllers\MiInstitucion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\MiInstitucion\ValidarSubDireccionRequest;
use App\Exports\MiInstitucion\Direccion\DireccionExport;
use App\Models\Historial\HistorialTipoRegistro;
use App\Models\MiInstitucion\SubDireccion;
use App\Models\MiInstitucion\Direccion;
use App\Models\Historial\HistorialAccion;
use Maatwebsite\Excel\Facades\Excel;
use Auth;

class SubDireccionesController extends Controller
{
    private $registro;
    private $svg_descripcion;
    private $ver;
    private $editar;
    private $borrar;

    public function __construct()
    {
        $this->registro = new SubDireccion();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $title_section = "Mi Institución / Sub-Direcciones";
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
        $historial_tipo_modulo = 11;
        $modulo_historial = 'direcciones';
        $link_ayuda = '#';
        $modulo_sistema = 'Mi Institución';
        $sub_modulo_sistema = 'Sub-Direcciones';
        
        $accesos = session('plataforma.accesos');
        $visualizador_accesos = $accesos[6]['acceso'] == 3 ? 'true' : 'false';

        return view('mi-institucion/sub-direcciones/index', compact('visualizador_accesos', 'title_section', 'general_messege', 'mensaje', 'error', 'tipo_registros_historial', 'historial_acciones', 'historial_tipo_modulo', 'modulo_historial', 'link_ayuda', 'modulo_sistema','sub_modulo_sistema') );
    }

    public function grid(Request $request)
    {
        if ($request->ajax()) {

            $lista =  $this->registro->listaGrilla();
            $this->svg_descripcion = svgIconos("ver-mas");
            $this->ver = svgIconos("ver");
            $this->editar = svgIconos("editar");
            $this->borrar = svgIconos("borrar");

            $datos = $lista->map(function ($subdireccion) {

                $css_color = ($subdireccion->estado_id == 0 ? 'bg-zn-inactivo' : 'bg-zn-activo');

                $subdireccion->borrar = '<span class="icon-borrar-subdireccion" subdireccion=' . $subdireccion->id.'>'.$this->borrar.'</span>';
                $subdireccion->editar = '<span class="icon-editar-subdireccion" subdireccion=' . $subdireccion->id.'>'.$this->editar.'</span>';
                $subdireccion->ver = '<span class="icon-ver-subdireccion" subdireccion=' . $subdireccion->id.'>'.$this->ver.'</span>';
                $subdireccion->estado = '<div class="zn-estado '.$css_color.'">'.$subdireccion->estado.'</div>';
                $subdireccion->estado_pnt = '<div class="w-3 h-3 justify-center ms-1 '.$css_color.' rounded-full"></div>';

                return $subdireccion;
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

        $title_section = "Mi Institución / Sub-Direcciones";
        $ruta = "mi-institucion/sub-direccion";
        $metodo = "POST";
        $tipo = "registrar";
        $etiqueta_accion = "Agregar";
        $tipo_registros_historial = HistorialTipoRegistro::filtroGrilla();
        $historial_acciones = accionesFiltroHistorial('Aplicaciones');
        $historial_tipo_modulo = 11;
        $modulo_historial = 'sub-direcciones';
        $link_ayuda = '#';
        $info_registro['direccion_id'] = '';
        $modulo_sistema = 'Mi Institución';
        $sub_modulo_sistema = 'Sub-Direcciones';
        $subDirecciones = Direccion::selectDirecciones();
        return view('mi-institucion/sub-direcciones/form', compact('title_section', 'ruta', 'metodo', 'tipo', 'etiqueta_accion', 'tipo_registros_historial', 'historial_acciones', 'historial_tipo_modulo', 'modulo_historial', 'link_ayuda', 'modulo_sistema', 'sub_modulo_sistema', 'subDirecciones', 'info_registro'));


    }

    public function store(ValidarSubDireccionRequest $request)
    {
        DB::beginTransaction();

        try {
            $data_registro = $this->arrayRequestRegistro($request);

            $subdireccion = $this->registro::create($data_registro);

            // Registrar en historial
            registroHistorialRegistro(1, $subdireccion->id, 11, $subdireccion->nombre);

            DB::commit();

            $mensaje = mensajeSuccess();
            $error = 0;
        } catch (\Exception $e) {
            DB::rollback();
            $mensaje = mensajeError('errGuardar');
            $error = 1;
        }

        return redirect('mi-institucion/sub-direcciones')->with(['general_messege' => true, 'mensaje' => $mensaje, 'error' => $error]);
    }







    public function show(Request $request, $tipo, $id)
    {

        $title_section = "Mi Institución / Sub-Direcciones";
        $ruta = $tipo == 'actualizar' ? "mi-institucion/sub-direccion/editar" : "mi-institucion/sub-direccion" ;
        $metodo = $tipo == 'actualizar' ? "POST" : '';

        /** Se obtiene la información */
        $info_registro = $this->registro->infoRegistro($id);

        $tipo_registros_historial = HistorialTipoRegistro::filtroGrilla();
        $historial_acciones = accionesFiltroHistorial('Aplicaciones');
        $historial_tipo_modulo = 11;
        $modulo_historial = 'sub-direcciones';
        $link_ayuda = '#';
        $modulo_sistema = 'Mi Institución';
        $sub_modulo_sistema = 'Sub-Direcciones';

        if ($info_registro['estado_id'] == 1){
            $info_registro['estado'] = "Activo";
            $info_registro['css_estado'] = "bg-zn-activo";
        } else {
            $info_registro['estado'] = "Inactivo";
            $info_registro['css_estado'] = "bg-zn-inactivo";
        }
        $etiqueta_accion = ($tipo == 'actualizar' ? "Actualizar" : "Información de ");
        $subDirecciones = Direccion::selectDirecciones();

        return view('mi-institucion/sub-direcciones/form', compact('title_section', 'info_registro', 'ruta', 'metodo', 'tipo', 'etiqueta_accion', 'tipo_registros_historial', 'historial_acciones', 'historial_tipo_modulo', 'modulo_historial', 'link_ayuda', 'modulo_sistema', 'sub_modulo_sistema', 'subDirecciones'));

    }


    public function update(ValidarSubDireccionRequest $request)
    {
        $error = 1;
        $mensaje = mensajeError('errGuardar');

        $data_registro = $this->arrayRequestRegistro($request);
        $id_datos = $request['idRegistro'];
        $registro = $this->registro::findOrFail($id_datos);

        $cambios = $this->arrayDatosModificados($data_registro, $registro);

        if ($cambios['cambios']) {
            DB::beginTransaction();
            try {
                if (isset($data_registro['direccion_id'])) {
                    $registro->direccion_id = $data_registro['direccion_id'];
                }
                if (isset($data_registro['descripcion'])) {
                    $registro->descripcion = $data_registro['descripcion'];
                }

                $registro->save();

                registroHistorialRegistro(3, $id_datos, 11, $registro->nombre, $cambios);

                $error = 0;
                $mensaje = mensajeSuccess();

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                dd($e);
            }
        }

        return redirect('mi-institucion/sub-direcciones')->with(['general_messege' => true, 'mensaje' => $mensaje, 'error' => $error]);
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
                registroHistorialRegistro(2, $registro_id, 11);
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
        if (!isset($request->inputEstado)){
            $request->inputEstado = 1;
        }

        $registro = array (
            'direccion_id' => $request->selectSubDireccion, // Aquí se asigna el valor del selector
            'descripcion' => $request->inputDescripcion,
            'estado_id' => $request->inputEstado,
        );

        return $registro;
    }





    private function arrayDatosModificados($request, $registro)
    {
        $campos = [
            'direccion_id',
            'descripcion',
            'estado_id'
        ];
        $campos_label = [30,7,5];

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
        if ($request->isMethod('post')) {
            $buscar['buscar_descripcion'] = $request->buscar_domicilio;

            $info['cliente_id'] = session('plataforma.user.cliente.id');
            $info['nombre_user'] = Auth::user()->nombre . ' ' . Auth::user()->apellido;
            $info['Perfil'] = session('plataforma.user.perfil.nombre');

            // Obtén los datos que deseas exportar, incluyendo 'direccion_id', 'descripcion', y 'estado_id'
            $info['sub_direcciones'] = $this->registro::obtenerInformacionXlsx($info['cliente_id'], $buscar)
                ->select('direccion_id', 'descripcion', 'estado_id')
                ->get();

            $info['filtros'] = $buscar;
            $nombre_aplicacion = env('APP_NAME');
            $fecha = date('d-m-Y H_i');
            $nombre_archivo = "{$nombre_aplicacion} - Mi Institución - Sub-Direcciones {$fecha}.xlsx";

            return (new SubDireccionExport($info))->download($nombre_archivo);
        } else {
            Auth::logout();
            return redirect('/login')->with('error', 'Error de sesión');
        }
    }

}
