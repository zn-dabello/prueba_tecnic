<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- Favicon -->
        <x-generales.favicon/>
        <title>@yield('title', '') | {{ env('APP_NAME') }}</title>
        {{-- Scripts --}}
        @vite(['resources/css/app.scss'])

        <!-- Turnstile -->
        @turnstileScripts()
    </head>
    <body>
        <!--Clase loginwrapper que está en _auth.scss-->
        <div class="loginwrapper">
            <div class="lg-inner-column">
                <div class="columna-izquierda relative z-[1]">
                    <!-- Contenido de la columna izquierda aquí -->
                </div>
                <div class="right-column relative">
                    <div class="inner-content h-full flex flex-col bg-white dark:bg-slate-800">
                        
                        @include('generales.barra-soporte')
                        
                        <div class="auth-box h-full flex flex-col justify-center">
                            <div class="mobile-logo text-center mb-6 lg:hidden flex justify-center">
                                <div class="mb-10 inline-flex items-center justify-center">
                                </div>
                            </div>
                            <div class="flex justify-center items-center 2xl:mb-10 mb-4">
                                <x-inicio.logo-general />
                            </div>
                            
                            {{ $slot }}
                        </div>
                        <div class="auth-footer text-center">
                            ZonaNube &reg; Todos los derechos reservados. 
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @vite(['resources/js/app.js'])
    </body>
</html>

<script>
        
    const elementos = document.querySelectorAll(".prevenir-envio");
    elementos.forEach(elemento => {
        elemento.addEventListener("keydown", (evento) => {
            if (evento.key == "Enter") {
                // Prevenir
                evento.preventDefault();
                return false;
            }
        });
    });
</script>
