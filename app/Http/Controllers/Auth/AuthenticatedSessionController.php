<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

use App\Models\User\User;
use App\Models\General\Cliente;
use App\Models\MiInstitucion\UserEncargaduria;
use App\Models\MiInstitucion\UserModuloAcceso;
use App\Models\User\Perfil;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $this->loginClientePerfil($request);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function authenticated(Request $request, $user)
    {
        $this->loginClientePerfil($request);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    
    public static function loginClientePerfil(Request $request)
    {
        $perfil = new Perfil();
        $cliente = new Cliente();
        $encargado = new UserEncargaduria();

        // Se valida los clientes activos para el usuarios 
        $clientes_user = $cliente->clientesActivosUsuario(Auth::user()->id);

        if (count($clientes_user) > 0) {

            /**
             * Asignacion del cliente
             */
            $cliente_id = $clientes_user[0]['id'];
            $request->session()->put('plataforma.user.cliente.id', $cliente_id);
            $request->session()->put('plataforma.user.cliente.razon_social', $clientes_user[0]['razon_social']);
            $request->session()->put('plataforma.user.cliente.nombre_fantasia', $clientes_user[0]['nombre_fantasia']);

            /**
             * Se valida los perfiles asignados para el usuario
             */
            $perfil_usuario = $perfil->perfilClienteUsuario(Auth::user()->id, $cliente_id);

            /**
             * Asignacion del perfil
             */
            $perfiles_id = $perfil_usuario[0]['id'];
            $request->session()->put('plataforma.user.perfil.id', $perfiles_id);
            $request->session()->put('plataforma.user.perfil.nombre', $perfil_usuario[0]['nombre']);
            
            /* Encargado */
            $encargado = UserEncargaduria::getDescripcion(Auth::user()->encargaduria_id);
            $request->session()->put('plataforma.encargado', $encargado[0]['descripcion']);
            
            /* Accesos */
            $accesos = UserModuloAcceso::accesosUsuarioSesion(Auth::user()->id);
            $request->session()->put('plataforma.accesos', $accesos);
        }
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function handleProviderCallback(Request $request, $provider)
    {
        // Obtenemos los datos del usuario
        $social_user = Socialite::driver($provider)->stateless()->user();
        //dd($user); // Sirve para visualizar que llega el callback antes de seguir con el codigo 

        if ($user = User::where('email', $social_user->email)->first()) {
            return $this->authAndRedirect($request, $user); // Login y redirección
        } else {
            return redirect('/login')->with('error', 'Este email no tiene una cuenta de usuario asociada');
        }
    }
    

    // Login y redirección
    public function authAndRedirect(Request $request, $user)
    {
        Auth::login($user);
        return $this->authenticated($request, $user);
    }
}
