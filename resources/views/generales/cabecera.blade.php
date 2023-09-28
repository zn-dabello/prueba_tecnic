
@php
    $re = '/\b(\w)[^\s]*\s*/m';
    $nombre_usuario = Auth::user('attributes')->nombre . ' ' . Auth::user('attributes')->apellido;
    $subst = '$1';

    $iniciales = preg_replace($re, $subst, $nombre_usuario);
    $perfil_user = session('plataforma.user.perfil.nombre');
    $encargado_sesion = session('plataforma.encargado');
@endphp
<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                    </svg>
                </button>
                <a href="#" class="flex ml-2 md:mr-8">
                <img src="{{ asset('img/zonanube/general/logo-zonanube-letras.png') }}" class="mr-20 w-32" alt="Logo Aplicacion" />
                <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white"></span>
                </a>
                <div class="flex justify-start hidden sm:block ms-6">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                            <div href="#" class="inline-flex items-center text-sm font-medium text-zn-azul-letras dark:text-gray-400 dark:hover:text-white">
                                <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                                </svg>
                                {{$modulo_sistema ?? 'Inicio'}}
                            </div>
                            </li>
                            <li>
                            <div class="flex items-center {{ $sub_modulo_sistema ?? 'hidden' }}">
                                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <div href="#" class="ml-1 text-sm font-medium text-zn-azul-letras md:ml-2 dark:text-gray-400 dark:hover:text-white">{{$sub_modulo_sistema ?? ''}}</div>
                            </div>
                            </li>
                            <li aria-current="page" class="sub-sub-modulo-sistema {{ $sub_sub_modulo_sistema ?? 'hidden' }}">
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                    </svg>
                                    <span class="txt-sub-sub-modulo-sistema ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ $sub_sub_modulo_sistema ?? '' }}</span>
                                </div>
                            </li>
                            <li aria-current="page" class="sub-sub-modulo-historial hidden">
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                    </svg>
                                    <span class="txt-sub-sub-modulo-sistema ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Historial</span>
                                </div>
                            </li>
                        </ol>
                        </nav>
                </div>
            </div>
        
            <div class="flex items-center">
                <div class="flex items-center ml-3">
                    <div>
                        <button type="button" class="flex text-sm bg-blue-900 text-white rounded-full focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-400" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="w-8  h-8 pt-1 rounded-full align-middle text-center font-bold">{{ $iniciales }}</span>
                        </button>
                    </div>
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
                    <div class="px-4 py-3" role="none">
                        <p class="text-sm text-gray-900 dark:text-white" role="none">
                            {{ $nombre_usuario }}
                        </p>
                        <p class="text-sm font-bold text-gray-900 truncate dark:text-gray-300" role="none">
                        Encargado de {{ $encargado_sesion }}
                        </p>
                    </div>
                    <ul class="py-1" role="none">
                        <li>
                            <a href="{{asset('mis-datos')}}" class="block px-4 py-2 text-sm text-zn-azul-letras hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Mis Datos</a>
                        </li>
                        <li>
                            <a href="{{asset('mis-datos/clave')}}" class="block px-4 py-2 text-sm text-zn-azul-letras hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Cambiar Contraseña</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center text-sm p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <svg class="flex-shrink-0 w-4 h-4 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h11m0 0-4-4m4 4-4 4m-5 3H3a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h3"/>
                                </svg>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button type="submit" class="flex-1 ml-3 whitespace-nowrap font-bold">
                                        Salir
                                    </button>
                                </form>
                                <!-- <span class="flex-1 ml-3 whitespace-nowrap font-bold">Salir</span> -->
                            </a>
                        </li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>