<?php

namespace App\Http\Controllers\MiInstitucion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\MiInstitucion\ValidarUsuarioRequest;
use App\Exports\MiInstitucion\Direccion\DireccionExport;
use App\Http\Requests\MiInstitucion\CambioClaveRequest;
use App\Models\Historial\HistorialTipoRegistro;
use App\Models\User\User;
use App\Mail\RegistroUser;
use App\Models\MiInstitucion\UserEncargaduria;
use App\Models\MiInstitucion\UserModuloAcceso;
use App\Models\Historial\HistorialAccion;
use App\Models\MiInstitucion\Direccion;
use App\Models\MiInstitucion\SubDireccion;
use App\Models\MiInstitucion\TipoAcceso;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Auth;

class MisDatosController extends Controller
{
    private $registro;
    private $svg_descripcion;
    private $ver;
    private $editar;
    private $borrar;
    private $tipo_registro;

    public function __construct()
    {
        $this->registro = new User();
        $this->middleware('auth');
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

    public function showSesion(Request $request)
    {

        $title_section = "Mis Datos";
        $ruta = "mis-datos" ;
        $tipo = 'visualizar';
        $metodo = $tipo == 'actualizar' ? "POST" : '';

        /** Se obtiene la información */
        $info_registro = $this->registro->infoRegistro(Auth::id());
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
        $modulo_sistema = 'Mis Datos';

        if ($info_registro['estado_id'] == 1){
            $info_registro['estado'] = "Activo";
            $info_registro['css_estado'] = "bg-zn-activo";
        } else {
            $info_registro['estado'] = "Inactivo";
            $info_registro['css_estado'] = "bg-zn-inactivo";
        }

        $etiqueta_accion = ($tipo == 'actualizar' ? "Actualizar" : "Información de ");
        $info_registro['array_encargadurias'] = UserEncargaduria::selectEncargadurias();
        $info_registro['array_direcciones'] = Direccion::selectDirecciones();
        $info_registro['array_subdirecciones'] = SubDireccion::selectSubDirecciones();
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

        return view('mi-institucion/usuarios/form-mis-datos', compact('tipo', 'title_section', 'info_registro', 'ruta', 'metodo', 'etiqueta_accion', 'tipo_registros_historial', 'historial_acciones', 'historial_tipo_modulo', 'modulo_historial', 'link_ayuda', 'modulo_sistema', 'modulos', 'submodulos', 'tipo_accesos', 'general_messege', 'mensaje', 'error'));

    }


    public function updateSesion(ValidarUsuarioRequest $request)
    {

        $error = 1;
        $mensaje = mensajeError('errGuardar');

        $data_registro = $this->arrayRequestRegistro($request);
        $id_datos  = Auth::id();
        $registro = $this->registro::findOrFail($id_datos);

        $cambios = $this->arrayDatosModificados($data_registro['usuario'], $registro);

        if ($cambios['cambios']) {
        
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
        
        return redirect('/')->with(['general_messege'=>true, 'mensaje'=>$mensaje, 'error'=>$error]); 

    }

    public function showClave(Request $request)
    {

        $title_section = "Cambiar Contraseña";
        $ruta = "mis-datos/clave" ;
        $tipo = 'actualizar';
        $metodo = $tipo == 'actualizar' ? "POST" : '';

        /** Se obtiene la información */
        $info_registro = $this->registro->infoRegistro(Auth::id());

        $tipo_registros_historial = HistorialTipoRegistro::filtroGrilla();
        $historial_acciones = accionesFiltroHistorial('Aplicaciones');
        $historial_tipo_modulo = 1;
        $modulo_historial = 'usuarios';
        $link_ayuda = '#';
        $modulo_sistema = 'Cambiar Contraseña';

        $general_messege = false;
        $mensaje = [];
        $error = 0;

        if ( $request->session()->get('general_messege') ){
            $general_messege = true;
            $mensaje = $request->session()->get('mensaje');
            $error = $request->session()->get('error');
        }

        return view('mi-institucion/usuarios/form-cambio-clave', compact('tipo', 'title_section', 'info_registro', 'ruta', 'metodo', 'tipo_registros_historial', 'historial_acciones', 'historial_tipo_modulo', 'modulo_historial', 'link_ayuda', 'modulo_sistema', 'general_messege', 'mensaje', 'error'));

    }

    public function showClaveUsuario( Request $request, $id_usuario = null )
    {

        $title_section = "Mi Institución / Cambiar Contraseña";
        $ruta = "usuario/clave" ;
        $tipo = 'actualizar';
        $metodo = $tipo == 'actualizar' ? "POST" : '';

        /** Se obtiene la información */
        $info_registro = $this->registro->infoRegistro($id_usuario);

        $tipo_registros_historial = HistorialTipoRegistro::filtroGrilla();
        $historial_acciones = accionesFiltroHistorial('Aplicaciones');
        $historial_tipo_modulo = 1;
        $modulo_historial = 'usuarios';
        $link_ayuda = '#';
        $modulo_sistema = 'Usuarios';

        $general_messege = false;
        $mensaje = [];
        $error = 0;

        if ( $request->session()->get('general_messege') ){
            $general_messege = true;
            $mensaje = $request->session()->get('mensaje');
            $error = $request->session()->get('error');
        }

        return view('mi-institucion/usuarios/form-cambio-clave', compact('tipo', 'title_section', 'info_registro', 'ruta', 'metodo', 'tipo_registros_historial', 'historial_acciones', 'historial_tipo_modulo', 'modulo_historial', 'link_ayuda', 'modulo_sistema', 'general_messege', 'mensaje', 'error'));

    }


    public function updateClave(CambioClaveRequest $request)
    {

        $error = 1;
        $mensaje = mensajeError('errGuardar');

        $data_registro = $this->arrayRequestRegistro($request);
        $id_datos  = Auth::id();
        $registro = $this->registro::findOrFail($id_datos);

        
            DB::beginTransaction();
            try {                    
                
                $registro->password = Hash::make($request->password);
                $registro->save();
                

                $error = 0;
                $mensaje = mensajeSuccess();

                DB::commit();

            } catch (\Exception $e) {
                DB::rollback();
            }
        
        return redirect('/')->with(['general_messege'=>true, 'mensaje'=>$mensaje, 'error'=>$error]); 

    }


    public function updateClaveUsuario(CambioClaveRequest $request)
    {

        $error = 1;
        $mensaje = mensajeError('errGuardar');

        $data_registro = $this->arrayRequestRegistro($request);
        $id_datos  = $request['idRegistro'];
        $registro = $this->registro::findOrFail($id_datos);

        
            DB::beginTransaction();
            try {                    
                
                $registro->password = Hash::make($request->password);
                $registro->save();
                

                $error = 0;
                $mensaje = mensajeSuccess();

                DB::commit();

            } catch (\Exception $e) {
                DB::rollback();
            }
        
        return redirect('/mi-institucion/usuarios')->with(['general_messege'=>true, 'mensaje'=>$mensaje, 'error'=>$error]); 

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
            'direccion_id' => $request['selectDireccion'],
            'subdireccion_id' => $request['selectSubDireccion'],
            'unidad_id' => $request['selectUnidad'],
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
}
