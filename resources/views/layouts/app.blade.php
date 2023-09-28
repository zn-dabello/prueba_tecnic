<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon -->
        <x-generales.favicon/>
        <title>@yield('title', '') | {{ env('APP_NAME') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.0/flowbite.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- JQGRID -->
        
        <link href="{{ versionedAsset('css/jQgrid/jQueryUI.css') }}" rel="stylesheet">
        <link href="{{ versionedAsset('css/jQgrid/ui.jqgrid-bootstrap.css') }}" rel="stylesheet">
        <script src="{{ versionedAsset('js/jQgrid/grid.locale-es.js') }}"></script>
        <script src="{{ versionedAsset('js/jQgrid/jqGrid.min.js') }}"></script>

        <!-- DATEPICKERS -->
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/datepicker.min.js"></script>

        <!-- ZN -->
        
        <script src="{{ versionedAsset('js/Generales/generales.js') }}"></script>
        <script src="{{ versionedAsset('js/Generales/modal.js') }}"></script>
        <script src="{{ versionedAsset('js/Generales/historiales.js') }}"></script>

        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-zn-azul-letras">
        <script type="text/javascript">
            /** Datos del usuario logeado */
            const auth_user = @json(Auth::user());
            /** Mensaje de Alerta */
            var mensaje_response_warning = @json(mensajeWarning(0,true));
            var mensaje_response_info = @json(mensajeInfo(0,true));
            var mensaje_response_input = @json(mensajeInput(0,true));
            var mensaje_response_error = @json(mensajeError(0,true));
            var mensaje_response_question = @json(mensajeQuestions(0,true));
            /** Dominio para uso en ajax */
            var dominio_app = 'https://{{ $_SERVER['SERVER_NAME'] }}';

            var tipo_modulo = {{ $historial_tipo_modulo ?? 3 }}; // por defecto modulo ficha
            var modulo_historial = '{{ $modulo_historial ?? "direcciones" }}'; // por defecto modulo ficha
            var tiene_listado = 1;
            var link_ayuda = @json($link_ayuda ?? []);
            var tipo_registros_historial = '{{ $tipo_registros_historial ?? [] }}';
            var historial_acciones = '{{ $historial_acciones ?? [] }}';    
            
            var visualizador_accesos = {{ $visualizador_accesos ?? 'true' }};

        </script>
        <div class="min-h-screen bg-gray-100">

            <!-- Page Content -->
            <main>
                @include('generales.cabecera')
                @include('generales.menu')
                @include('generales.modal-nube')
                @include('generales.modal-mensajes')

                <div class="p-4 sm:ml-64 ">

                    <div class="py-12 content-sistema">
                        @yield('content')
                        
                    </div>
                    

                    <div class="py-12 content-historial hidden">
                        @include('historiales.index')
                    </div>
                    <div class="py-12 content-historial-detalle" id="contentHistorialDetalle">
                    </div>

                </div>
            </main>
        </div>
    </body>
    <script>
        $(document).ready(function(){
            @if ( isset( $general_messege ) && $general_messege )

                var mensajeSistema = @json($mensaje);
                var errorMensaje = @json($error);

                modales.alert(errorMensaje, mensajeSistema)

            @endif
        });
    </script>
</html>
