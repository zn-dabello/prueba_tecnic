@section('title', 'Ingreso')
<x-guest-layout>
    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center text-zn-azul-opaco">
        Iniciar Sesión
    </h2>
    <!-- INICIO::LOGIN FORM -->
    <form method="POST" action="{{ route('login') }}" novalidate class="space-y-4">
        @csrf

        <x-inicio.input-label-required for="usuario" :value="__('Nombre De Usuario')" />
        <x-inicio.input-sesion type="usuario" name="usuario" id="usuario" class="form-control py-2 prevenir-envio" value="{{ old('usuario') }}"  autofocus value="{{ old('usuario') }}" />
        <x-inicio.input-error :messages="$errors->first('usuario')" class="mt-2" />

        <x-inicio.input-label-required for="password" :value="__('Contraseña')" />
        <x-inicio.input-sesion type="password" name="password" class="form-control py-2 prevenir-envio" id="password" autocomplete="current-password" />
        <x-inicio.input-error :messages="$errors->first('password')" class="mt-2" />

        <div class="flex justify-between">
            <div class="checkbox-area">
                    <x-inicio.checkbox-sesion />
                    <span class="text-slate-500 dark:text-slate-400 text-sm leading-6 ml-2">{{ __('Recordarme') }}</span>
            </div>
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none" href="{{ route('password.request') }}">
                    {{ __('¿Olvidó la contraseña?') }}
                </a>
            @endif
        </div>

        <div class="flex items-center justify-center mt-4">
            <x-turnstile
                data-action="login"
                data-cdata="sessionid-123456789"
                data-callback="callback"
                data-expired-callback="expiredCallback"
                data-error-callback="errorCallback"
                data-theme="light"
                data-tabindex="1"
            />
        </div>

        <x-inicio.input-error :messages="$errors->first('cf-turnstile-response')" class="mt-2" />

        <button type="submit"
            class="btn btn-dark block w-full text-center">
            {{ __('Ingresar') }}
        </button>

        <div class="relative border-b-[#9AA2AF] border-opacity-[16%] border-b pt-6">
            <div class="absolute inline-block bg-white dark:bg-slate-800 dark:text-slate-400 left-1/2 top-1/2 transform -translate-x-1/2 px-4 min-w-max text-sm text-slate-500 font-normal">
                {{ __('Continuar con') }}
            </div>
        </div>
        <x-inicio.inicio-sesion-rsociales > </x-inicio.inicio-sesion-rsociales>
    </form>
    <!-- FIN::LOGIN FORM -->
    <div class="flex justify-between">
        <h2 class="text-left">
            <a class="text-sm font-light" href="https://zonanube.cl/nuestros-terminos" target="_blank">Términos y condiciones</a>
        </h2>
        <h2 class="text-right">
            <a class="text-sm font-light" href="https://zonanube.cl/nuestras-politicas" target="_blank">Política de privacidad</a>
        </h2>
    </div>
</x-guest-layout>
