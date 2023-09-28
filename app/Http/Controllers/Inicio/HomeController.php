<?php

namespace App\Http\Controllers\Inicio;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Historial\HistorialTipoRegistro;
use App\Models\Historial\HistorialAccion;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $mensaje_bienvenida = "Bienvenido al inicio";
        $title_section = "Dashboard";

        $tipo_registros_historial = HistorialTipoRegistro::filtroGrilla();
        $historial_acciones = accionesFiltroHistorial('Aplicaciones');
        $historial_tipo_modulo = 3;
        $modulo_historial = 'direcciones';
        $link_ayuda = '#';
        $modulo_sistema = 'Inicio';
        
        $general_messege = false;
        $mensaje = [];
        $error = 0;

        if ( $request->session()->get('general_messege') ){
            $general_messege = true;
            $mensaje = $request->session()->get('mensaje');
            $error = $request->session()->get('error');
        }

        return view('dashboard', compact('general_messege','mensaje','error','mensaje_bienvenida','title_section', 'tipo_registros_historial', 'historial_acciones', 'historial_tipo_modulo', 'modulo_historial', 'link_ayuda', 'modulo_sistema') );
    }

    

    public function prueba()
    {
        $mensaje = "Bienvenido al inicio";
        return view('dashboard');
    }
}
