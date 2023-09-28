<!DOCTYPE html>
<html lang="en" class="light">
    <!-- PRINCIPIO: Head -->
    <head>
        <meta charset="utf-8">
        <link href="{{ asset('images/zona_nubelogo.png') }}" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="ZONANUBE">
        <title>Ingreso | ZonaNube</title>
        <!-- PRINCIPIO: CSS Assets-->
        <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('img/zonanube/general/favicon.ico') }}">
        <!-- FINAL: CSS Assets-->
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        {{ romanzipp\Turnstile\Captcha::getScript() }}
    </head>
    <!-- FINAL: Head -->
    <body class="login">
        <div class="container sm:px-10">
            <div class="block xl:grid grid-cols-2 gap-4">
                <!-- PRINCIPIO: Login Info -->
                <div class="hidden xl:flex flex-col min-h-screen">
                </div>
                <div class="flex justify-center items-center h-screen">
                    @yield('content')
                </div>
            </div>
        </div>

    </body>
</html>
