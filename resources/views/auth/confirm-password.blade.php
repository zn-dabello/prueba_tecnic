<x-guest-layout>
    <div class="auth-box h-full flex flex-col justify-center">
        <div class="mobile-logo text-center mb-6 lg:hidden block">
            <div class="mb-10 inline-flex items-center justify-center">
                <x-inicio.logo-general />
                <span class="ltr:ml-3 rtl:mr-3 text-xl  font-bold text-slate-900 dark:text-white">ZonaNube</span>
            </div>
        </div>
        <div class="w-full px-4 sms:px-0 sm:w-[450px]">
            <div class="mb-4 text-sm text-slate-600">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                {{-- contraseña --}}
                <div>
                    <x-inicio.input-label for="password" :value="__('Password')" />

                    <x-inicio.text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />

                    <x-inicio.input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex justify-end mt-4">
                    <x-inicio.primary-button>
                        {{ __('Confirm') }}
                    </x-inicio.primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
