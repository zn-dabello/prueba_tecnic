@section('title', $title_section)
@extends('layouts.app')
@section('content')
@php 
    $mostrar_input = ['registrar', 'actualizar'];
    $mostrar_estado = ['visualizar', 'actualizar'];
    $mostrar_form = in_array($tipo, $mostrar_input) ? true : false;
    $array_estados = ['0' => 'primary', '1' => 'success', '2' => 'light']; 

@endphp

    <script type="text/javascript">
        var tipo_accion = '{{ $tipo }}';
    </script>

    <div id="accordion-open" data-accordion="open" class="mt-2">
        <h2 id="accordion-collapse-heading-1">
            <button type="button" class="flex items-center hover:bg-gray-200 font-semibold text-lg justify-between w-full px-5 py-2 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-1" aria-expanded="true" aria-controls="accordion-collapse-body-1">
            <span>Cambiar Contraseña</span>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
            </button>
        </h2>
        <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
            <div class="p-5 border border-gray-200 dark:border-gray-700 dark:bg-gray-900 bg-white">
                <form method="{{$metodo}}" action="{{ route($ruta) }}"  class="w-full" id="form-usuario" accept-charset="UTF-8" enctype="multipart/form-data" >
                    @csrf
                    @if ($tipo == 'actualizar')
                        @method('PATCH')
                        <input type="hidden" name="idRegistro" value="{{$info_registro['id']}}" />
                        <input type="hidden" name="formatoValidoPassword" id="formatoValidoPassword" value="0" />
                        <input type="hidden" name="confirmado" id="confirmado" value="0" />
                    @endif
                    <div class="space-y-8 w-full xl:w-3/5">
                        <div class="lg:grid lg:grid-cols-2 lg:gap-2">
                    <!-- Datos -->
                            <div class="my-1">
                                <x-generales.zn-label for="inputCorreo" :value="__('Nombre')" class=""  />

                                <x-generales.zn-mostrar-datos value="{{ $info_registro['nombre'] . ' ' .$info_registro['nombre']  }}" class="w-100" />

                            </div>
                            <div class="my-1">
                                <!-- Password -->

                                
                                <x-inicio.input-label for="password" :value="__('Contraseña')" />
                                <div class="relative w-full">
                                    <x-inicio.input-sesion name="password" id="password" class="campoPass mt-1 w-full prevenir-envio" type="password" name="password" required autocomplete="new-password" />
                                    <button data-ver=0 type="button" class="btn-password absolute top-0 right-0 h-full p-2.5 text-sm font-medium text-white bg-blue-900 rounded-r-lg border border-blue-900 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="pass-ver w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="pass-no-ver hidden w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                        </svg>

                                        <span class="sr-only">Ver</span>
                                    </button>
                                </div>
                                <x-generales.input-error :messages="$errors->first('password')" class="mt-2" />

                                <!-- Confirm Password -->
                                <div>
                                    <x-inicio.input-label for="password_confirmation" :value="__('Confirma contraseña')" />

                                    <div class="relative w-full">
                                        <x-inicio.input-sesion name="password_confirmation" id="password_confirmation" class="block mt-1 w-full prevenir-envio"
                                                            type="password"
                                                            name="password_confirmation" required autocomplete="new-password" />
                                        <button data-ver=0 type="button" class="btn-confirmation absolute top-0 right-0 h-full p-2.5 text-sm font-medium text-white bg-blue-900 rounded-r-lg border border-blue-900 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="confirm-ver w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="confirm-no-ver hidden w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                        </svg>
                                        <span class="sr-only">Ver</span>
                                        </button>
                                    </div>
                                    <x-generales.input-error :messages="$errors->first('password_confirmation')" class="mt-2" />
                                </div>
                                
                                <div>
                                    <h2 class="my-2 text-lg font-semibold text-gray-900 dark:text-white">La contraseña debe contener:</h2>
                                    <ul class="max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400">
                                        <li class="flex items-center">
                                            <svg class="item-campo-length-bien hidden w-3.5 h-3.5 mr-2 text-green-500 dark:text-green-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                            </svg>
                                            <svg class="item-campo-length-mal w-3.5 h-3.5 mr-2 text-gray-500 dark:text-gray-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                            </svg>
                                            M&iacute;nimo 8 caracteres
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="item-campo-mayuscula-bien hidden w-3.5 h-3.5 mr-2 text-green-500 dark:text-green-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                            </svg>
                                            <svg class="item-campo-mayuscula-mal w-3.5 h-3.5 mr-2 text-gray-500 dark:text-gray-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                            </svg>
                                            M&iacute;nimo 1 letra may&uacute;scula
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="item-campo-minuscula-bien hidden w-3.5 h-3.5 mr-2 text-green-500 dark:text-green-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                            </svg>
                                            <svg class="item-campo-minuscula-mal w-3.5 h-3.5 mr-2 text-gray-500 dark:text-gray-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                            </svg>
                                            M&iacute;nimo 1 letra min&uacute;scula
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="item-campo-digito-bien hidden w-3.5 h-3.5 mr-2 text-green-500 dark:text-green-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                            </svg>
                                            <svg class="item-campo-digito-mal w-3.5 h-3.5 mr-2 text-gray-500 dark:text-gray-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                            </svg>
                                            M&iacute;nimo 1 n&uacute;mero
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            @if($tipo != 'visualizar')
                                <x-generales.zn-btn-enviar value="Guardar" />
                            @endif
                            <x-generales.zn-btn-cancelar value="Cancelar" href="{{ route('mi-institucion/usuarios')}}" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ versionedAsset('js/App/MiInstitucion/validar_clave.js') }}"></script>
@endsection