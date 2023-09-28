@section('title', 'Recuperar Contraseña')
<x-guest-layout>
    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left" style="color: #384e73;">
        Recuperar contraseña
    </h2>
    <!-- <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div> -->

    <!-- Session Status -->
    <x-inicio.auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="py-2">
            <x-inicio.input-label-required for="usuario" :value="__('Nombre de Usuario o E-mail')" class="mb-4" />
            <x-inicio.input-sesion type="usuario" name="usuario" id="usuario" class="form-control py-2 prevenir-envio" value="{{ old('usuario') }}" placeholder="{{ __('Ingrese su usuario') }}" autofocus value="{{ old('usuario') }}" />
            <x-inicio.input-error :messages="$errors->first('usuario')" class="mt-2" />
            <!-- <x-inicio.input-label for="email" :value="__('Email')" />
            <x-inicio.text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-inicio.input-error :messages="$errors->get('email')" class="mt-2" /> -->
        </div>

        <div class="items-center justify-end mt-4">

        <!-- <button type="submit"
            class="btn btn-dark block w-full text-center">
            {{ __('Recuperar Contraseña') }}
        </button> -->
            <x-inicio.primary-button>
                Solicitar Contraseña
            </x-inicio.primary-button>
            <x-inicio.cancel-button class="mt-1" href="{{ asset('login') }}">
                Volver
            </x-inicio.cancel-button>
        </div>
    </form>
</x-guest-layout>
