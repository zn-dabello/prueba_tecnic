<?php

namespace App\Http\Controllers\MiInstitucion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\MiInstitucion\ValidarUsuarioRequest;
use App\Exports\MiInstitucion\Direccion\DireccionExport;
use App\Models\Historial\HistorialTipoRegistro;
use App\Models\User\User;
use App\Mail\RegistroUser;
use App\Models\MiInstitucion\UserEncargaduria;
use App\Models\MiInstitucion\UserModuloAcceso;
use App\Models\Historial\HistorialAccion;
use App\Models\MiInstitucion\Direccion;
use App\Models\MiInstitucion\SubDireccion;
use App\Models\MiInstitucion\TipoAcceso;
use App\Models\MiInstitucion\Unidad;
use App\Models\User\UserEstado;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Auth;

use function PHPUnit\Framework\isNull;

class UsuarioController extends Controller
{
    private $registro;
    private $svg_descripcion;
    private $ver;
    private $editar;
    private $borrar;
    private $llave;
    private $tipo_registro;

    public function __construct()
    {
        $this->registro = new User();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $title_section = "Mi Institución / Direcciones";
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
        $historial_tipo_modulo = 1;
        $modulo_historial = 'usuarios';
        $link_ayuda = '#';
        $modulo_sistema = 'Mi Institución';
        $sub_modulo_sistema = 'Usuarios';
        
        $accesos = session('plataforma.accesos');
        $visualizador_accesos = $accesos[8]['acceso'] == 3 ? 'true' : 'false';
        // Select busqueda estado
        $tipo_estados = UserEstado::filtroGrilla();

        return view('mi-institucion/usuarios/index', compact('visualizador_accesos', 'tipo_estados', 'title_section', 'general_messege', 'mensaje', 'error', 'tipo_registros_historial', 'historial_acciones', 'historial_tipo_modulo', 'modulo_historial', 'link_ayuda', 'modulo_sistema','sub_modulo_sistema') );
    }

    public function grid(Request $request)
    {
        if ($request->ajax()) {

            $lista =  $this->registro->listaGrilla();
            $this->svg_descripcion = svgIconos("ver-mas");
            $this->ver = svgIconos("ver");
            $this->editar = svgIconos("editar");
            $this->borrar = svgIconos("borrar");
            $this->llave = svgIconos("llave");

            $datos = $lista->map(function ($dato) {

                $css_color = ($dato->estado_id == 0 ? 'bg-zn-inactivo' : 'bg-zn-activo');

                $dato->borrar = $dato->id != 1 ? '<span class="icon-borrar-usuario" usuario=' . $dato->id.' title="Borrar">'.$this->borrar.'</span>' : '-';
                $dato->editar = '<span class="icon-editar-usuario" usuario=' . $dato->id.' title="Editar">'.$this->editar.'</span>';
                $dato->ver = '<span class="icon-ver-usuario" usuario=' . $dato->id.' title="Ver">'.$this->ver.'</span>';
                $dato->clave = '<span class="icon-clave-usuario" usuario=' . $dato->id.' title="Ver">'.$this->llave.'</span>';
                $dato->estado_min = $dato->estado;
                $dato->estado = '<div class="zn-estado '.$css_color.'">'.$dato->estado.'</div>';
                $dato->estado_pnt = '<div class="w-3 h-3 justify-center ms-1 '.$css_color.' rounded-full"></div>';
                $telefono = $dato->telefono;
                $dato->telefono = visualTelefono($telefono);
                if (mb_strlen($dato->nombre) > 30) {
                    $dato->nombre = (!empty($dato->nombre) ? '<div class="flex"><div class="icon-descripcion cursor-pointer" contenido="'.$dato->nombre.'">'.$this->svg_descripcion.'</div> &nbsp;<div>'.quitarSaltoLinea($dato->nombre, 30, false) : '').'</div></div>';
                }
                else {
                    $dato->nombre = $dato->nombre;
                }

                if (mb_strlen($dato->direccion) > 35) {
                    $dato->direccion = (!empty($dato->direccion) ? '<div class="flex"><div class="icon-descripcion cursor-pointer flex" contenido="'.$dato->direccion.'">'.$this->svg_descripcion.'</div> &nbsp;<div>'.quitarSaltoLinea($dato->direccion, 35, false) : '').'</div></div>';
                }
                else {
                    $dato->direccion = quitarSaltoLinea($dato->direccion, false, false);
                }
                return $dato;
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

        $title_section = "Mi Institución / Direcciones";
        $ruta = "mi-institucion/usuario";
        $metodo = "POST";
        $tipo = "registrar";
        $etiqueta_accion = "Agregar";
        $tipo_registros_historial = HistorialTipoRegistro::filtroGrilla();
        $historial_acciones = accionesFiltroHistorial('Aplicaciones');
        $historial_tipo_modulo = 1;
        $modulo_historial = 'usuarios';
        $link_ayuda = '#';
        $modulo_sistema = 'Mi Institución';
        $sub_modulo_sistema = 'Usuarios';

        $info_registro['array_encargadurias'] = UserEncargaduria::selectEncargadurias();
        $info_registro['array_direcciones'] = Direccion::selectDirecciones();
        $info_registro['array_subdirecciones'] = SubDireccion::selectSubDirecciones();
        $info_registro['array_unidades'] = Unidad::selectUnidades();
        $info_registro['encargaduria_id'] = "";
        $info_registro['subdireccion_id'] = "";
        $info_registro['direccion_id'] = "";
        $info_registro['unidad_id'] = "";

        return view('mi-institucion/usuarios/index-form', compact('title_section', 'ruta', 'metodo', 'tipo', 'etiqueta_accion', 'tipo_registros_historial', 'historial_acciones', 'historial_tipo_modulo', 'modulo_historial', 'link_ayuda', 'modulo_sistema','sub_modulo_sistema', 'info_registro'));

    }

    public function store(ValidarUsuarioRequest $request)
    {

        $error = 1; // 1: no es peticion post
        $mensaje = mensajeError('errGuardar');
        $cliente_user = session('plataforma.user.cliente.id');

        if ($this->registro->validarExistenciaEmail($request['inputCorreo'], $cliente_user)) {

            $mensaje = mensajeError('errEmail');
            $data['error_input'] = 'inputCorreo';

            return redirect()->route('mi-institucion/usuario')->withInput()->withErrors(['inputCorreo' => 'El correo electrónico ya se encuentra registrado']);

        } elseif ($this->registro->validarExistenciaUsuario($request['inputUsuario'], $cliente_user)) {

            $mensaje = mensajeError('errUsuario');
            $data['error_input'] = 'inputUsuario';
            return redirect()->route('mi-institucion/usuario')->withInput()->withErrors(['inputUsuario' => 'El usuario ya se encuentra registrado']);

        }
        else{

            DB::beginTransaction();

            try {
                $this->tipo_registro = 'registrar';
                $data_registro = $this->arrayRequestRegistro($request);
                $clave = generateRandomString(8);
                $data_registro['usuario']['password'] = Hash::make($clave);

                $registro = $this->registro::create($data_registro['usuario']);
                
                \DB::statement("INSERT INTO user_modulo_accesos (user_id, modulo_id, tipo_acceso_id)
                        SELECT DISTINCT {$registro->id}, m.id, 1
                        FROM
                            modulos m
                        WHERE
                            m.estado_id = 1;");

                /** Registro en historial */
                $listados['listados_tipo_registro'] = "4";
                registroHistorialRegistro(1, $registro->id, 1, $registro->nombre.' '. $registro->apellido, $listados);

                /** Envio de correo] */
                $destinatario = $registro->email;
                // Informacion para el Mail
                $user_mail['nombre_user'] = sprintf('%s %s', $registro->nombre, $registro->apellido);
                $user_mail['email'] = $registro->email;
                $user_mail['username'] = $registro->usuario;
                $user_mail['clave'] = $clave;
                
                Mail::to($destinatario)->send(new RegistroUser($user_mail));


                DB::commit();

                $registro = $registro->id;
                
                $error = 0;
                $mensaje = mensajeSuccess();

            } catch (\Exception $e) {
                DB::rollback();
            }
        }

        return redirect('mi-institucion/usuarios')->with(['general_messege'=>true, 'mensaje'=>$mensaje, 'error'=>$error]); 

    }

    public function show(Request $request, $tipo, $id)
    {

        $title_section = "Mi Institución / Direcciones";
        $ruta = $tipo == 'actualizar' ? "mi-institucion/usuario/editar" : "mi-institucion/usuario" ;
        $metodo = $tipo == 'actualizar' ? "POST" : '';

        /** Se obtiene la información */
        $info_registro = $this->registro->infoRegistro($id);
        $info_registro['subdireccion_id'] = is_null( $info_registro['subdireccion_id'] ) ? '' : $info_registro['subdireccion_id'];
        $info_registro['unidad_id'] = is_null( $info_registro['unidad_id'] ) ? '' : $info_registro['unidad_id'];
        
        if ($info_registro['telefono']) {
            $telefono = explode('|', $info_registro['telefono']);
            $info_registro['telefono'] = $telefono[1];
            $info_registro['digito'] = $telefono[0];
        } else {
            $info_registro['digito'] = 2;
        }

        $tipo_registros_historial = HistorialTipoRegistro::filtroGrilla();
        $historial_acciones = accionesFiltroHistorial('Aplicaciones');
        $historial_tipo_modulo = 1;
        $modulo_historial = 'usuarios';
        $link_ayuda = '#';
        $modulo_sistema = 'Mi Institución';
        $sub_modulo_sistema = 'Usuarios';

        if ($info_registro['estado_id'] == 1){
            $info_registro['estado'] = "Activo";
            $info_registro['css_estado'] = "bg-zn-activo";
        } else {
            $info_registro['estado'] = "Inactivo";
            $info_registro['css_estado'] = "bg-zn-inactivo";
        }

        $etiqueta_accion = ($tipo == 'actualizar' ? "Actualizar" : "Información del ");
        $info_registro['array_encargadurias'] = UserEncargaduria::selectEncargadurias();
        $info_registro['array_direcciones'] = Direccion::selectDirecciones();
        $info_registro['array_subdirecciones'] = SubDireccion::selectSubDirecciones();
        $info_registro['array_unidades'] = Unidad::selectUnidades();
        $modulos = UserModuloAcceso::selectModuloAccesos($info_registro['id']);
        $submodulos = UserModuloAcceso::selectSubModuloAccesos($info_registro['id']);
        $tipo_accesos = TipoAcceso::selectTipoAccesos($info_registro['id']);

        $general_messege = false;
        $mensaje = [];
        $error = 0;

        if ( $request->session()->get('general_messege') ){
            $general_messege = true;
            $mensaje = $request->session()->get('mensaje');
            $error = $request->session()->get('error');
        }


        return view('mi-institucion/usuarios/index-form', compact('tipo', 'title_section', 'info_registro', 'ruta', 'metodo', 'etiqueta_accion', 'tipo_registros_historial', 'historial_acciones', 'historial_tipo_modulo', 'modulo_historial', 'link_ayuda', 'modulo_sistema','sub_modulo_sistema', 'modulos', 'submodulos', 'tipo_accesos', 'general_messege', 'mensaje', 'error'));

    }


    public function update(ValidarUsuarioRequest $request)
    {

        $error = 1;
        $mensaje = mensajeError('errGuardar');

        $data_registro = $this->arrayRequestRegistro($request);
        $id_datos  = $request['idRegistro'];
        $registro = $this->registro::findOrFail($id_datos);
     
        $cambios = $this->arrayDatosModificados($data_registro['usuario'], $registro);
        $cliente_user = session('plataforma.user.cliente.id');

        if ($cambios['cambios']) {

            if ( $this->registro->validarExistenciaEmail($request['inputCorreo'], $cliente_user, $registro->id) ) {

                return redirect()->route('mi-institucion/usuario')->withInput()->withErrors(['inputCorreo' => 'El correo electrónico ya se encuentra registrado']);

            } else {
        
                DB::beginTransaction();
                try {                    
                    if (isset($data_registro['usuario'])){
                        $registro->update($data_registro['usuario']);
                    }
                    
                    /** Registro en historial */
                    registroHistorialRegistro(3, $id_datos, 1, $registro->nombre.' '. $registro->apellido, $cambios);

                    $error = 0;
                    $mensaje = mensajeSuccess();

                    DB::commit();

                } catch (\Exception $e) {
                    DB::rollback();
                }
            }

        }
        
        return redirect('mi-institucion/usuario/actualizar/'.$registro->id)->with(['general_messege'=>true, 'mensaje'=>$mensaje, 'error'=>$error]); 

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
            $registro->user_estado_id = -1;
            

            DB::beginTransaction();

            try {
                $registro->save();
                /** Registro en historial */
                registroHistorialRegistro(2, $registro_id, 1);
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
        $apellido = explode(" ", $request['inputApellido']);
        $registro['usuario'] = array (
            'email' => $request['inputCorreo'],
            'nombre' => $request['inputNombre'],
            'apellido' => $request['inputApellido'],
            'encargaduria_id' => $request['selectEncargado'],
            'direccion_id' => $request['selectEncargado'] > 2 ? $request['selectDireccion'] : null,
            'subdireccion_id' => $request['selectEncargado'] > 3 ? $request['selectSubDireccion'] : null,
            'unidad_id' => $request['selectEncargado'] > 4 ? $request['selectUnidad'] : null,
            'rut' => $request['inputRut'],
            'telefono' => $request['inputTelefono'],
            'cargo' => $request['inputCargo'],
            'usuario' => $request['inputUsuario'],
            'user_estado_id' => $request['inputEstado']
        );

        if ($this->tipo_registro == 'registrar') {
            $registro['usuario']['cliente_id'] = env('CLIENTE_ACTIVO');
        }

        return $registro;

    }

    private function arrayDatosModificados($request, $registro)
    {
        $campos = [
            'email',
            'nombre',
            'apellido',
            'encargaduria_id',
            'direccion_id',
            'subdireccion_id',
            'unidad_id',
            'rut',
            'telefono',
            'cargo',
            'usuario',
            'user_estado_id'
        ];
        $campos_label = [15,1,9,10,30,11,16,12,3,13,14,6];
 
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
            $info['Perfil']         =   session('plataforma.user.perfil.nombre');
            $info['direcciones']      =   $this->registro::obtenerInformacionXlsx($info['cliente_id'], $buscar);
            $info['filtros']        =   $buscar;
            $nombre_aplicacion = env('APP_NAME') ;
            $fecha = date('d-m-Y H_i') ;
            $nombre_archivo = "{$nombre_aplicacion} - Mi Institución - Direcciones {$fecha}.xlsx";

            return (new DireccionExport($info))->download($nombre_archivo);

        }else{
            Auth::logout();
            return redirect('/login')->with('error','Error de sesión');
        }
    }

    // ACCESOS
    public function updateAccesos(Request $request)
    {

        $error =   1; 
        $data =   [
            'error' =>  1,
            'response' => mensajeError('errActualizar')
        ];

        $array_accesos = json_decode($request['inputDatosAcccesos'], true);
        $id = $request['idRegistro'];

        DB::beginTransaction();
        try {                    

            foreach ($array_accesos as $key => $value) {

                if( isset($value['acceso']) ) {
                    UserModuloAcceso::where('id', $value['acceso'])->where('user_id', $id)->update(['tipo_acceso_id' => $value['tipo_acceso']]);
                }
            }
            if ( $id == Auth::user()->id) {
                $accesos = UserModuloAcceso::accesosUsuarioSesion(Auth::user()->id);
                $request->session()->put('plataforma.accesos', $accesos);
            }

            /** Registro en historial */
            // registroHistorialRegistro(3, $id_datos, 1, $registro->nombre.' '. $registro->apellido, $cambios);

            DB::commit();

            $error = 0;
            $data['error'] = 0;
            $data['mensaje'] = mensajeSuccess('succGuardar');

        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json([
            'error' => $error,
            'success' => $data
        ]);

    }

}
