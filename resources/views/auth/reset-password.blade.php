<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-inicio.input-label for="email" :value="__('Email')" />
            <x-inicio.input-sesion id="email" class="block mt-1 w-full prevenir-envio disabled:opacity-75" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-inicio.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-inicio.input-label for="password" :value="__('Contraseña')" />
            <x-inicio.input-sesion id="password" class="block mt-1 w-full prevenir-envio" type="password" name="password" required autocomplete="new-password" />
            <x-inicio.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-inicio.input-label for="password_confirmation" :value="__('Confirma contraseña')" />

            <x-inicio.input-sesion id="password_confirmation" class="block mt-1 w-full prevenir-envio"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-inicio.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-inicio.primary-button>
                {{ __('Reestablecer Contraseña') }}
            </x-inicio.primary-button>
        </div>
    </form>
</x-guest-layout>
