<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccesoModificarUsuario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $modulo = 0, $superrior1 = 0, $superrior2 = 0): Response
    {

        /** se valida el estado habilitado el perfil del usuario cliente */
        $accesos = session('plataforma.accesos');
        if ( $modulo != 0 && $superrior1 != 0 && $superrior2 != 0) {
            if ( $accesos[$modulo]['acceso'] != 2 || $accesos[$superrior1]['acceso'] != 2 || $accesos[$superrior2]['acceso'] != 2 ){
                return redirect('/dashboard')->with(['general_messege'=>true, 'mensaje'=>mensajeWarning('warnAcceso'), 'error'=>1],);
            }
        } else if ( $modulo != 0 && $superrior1 != 0) {
            if ( $accesos[$modulo]['acceso'] != 2 || $accesos[$superrior1]['acceso'] != 2 ){
                return redirect('/dashboard')->with(['general_messege'=>true, 'mensaje'=>mensajeWarning('warnAcceso'), 'error'=>1],);
            }
        } else if( $modulo != 0 ){
            if ( $accesos[$modulo]['acceso'] != 2 ){
                return redirect('/dashboard')->with(['general_messege'=>true, 'mensaje'=>mensajeWarning('warnAcceso'), 'error'=>1],);
            }
        }

        return $next($request);
    }
}
