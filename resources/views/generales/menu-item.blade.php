<?php
/**
  * Esta vista esta separada del menu principal con el objetivo de llamarse recursivamente, con la idea de que existan N cantidad de submenus
  * @param [type] $[item] [Datos del menu item]
  * @param [type] $[nuvel] [Nivel de Submenu]
  * @return [html] [listado del menú segun Perfil del usuario]
  * @date  04-08-2024
  * @copyright ZonaNube (zonanube.cl)
  * @author Raudely Pimentel <rpimentel@zonanube.com>
  */
?>

<?php /*Si contiene no contiene submenu se imprime el item*/ ?>
@php 
    $accesos_user = session('plataforma.accesos'); 
@endphp

@if( $accesos_user[$item['modulo_id']]['acceso'] > 1  )

    @if ($item['submenu'] == [])
        <?php /*Si el nivel es mayor a 1 se trata de un submenu, por lo que las clases y el formato del <li> y el <a> con distitos al principal */ ?>
        @if ( $nivel > 1 )
            <li>
                <a href="{{ ($item['ruta'] != '#' ? route($item['ruta']) : $item['ruta']) }}" class="flex items-center p-2 {{ $item['descripcion'] == existe($modulo_sistema) || $item['descripcion'] == existe($sub_modulo_sistema) || $item['descripcion'] == existe($sub_sub_modulo_sistema) ? 'text-zn-azul-opaco bg-gray-100' : 'text-zn-azul-letras' }} rounded-lg dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 group">
                    <span class="{{ $item['espacio'] > 0 ? 'ml-'.$item['espacio'] : 'ml-1' }}  font-bold">{{ $item['descripcion'] }} </span>
                </a>
        @else
            <li>
                <a href="{{ ($item['ruta'] != '#' ? route($item['ruta']) : $item['ruta']) }}" class="flex items-center p-2 {{ $item['descripcion'] == existe($modulo_sistema) || $item['descripcion'] == existe($sub_modulo_sistema) || $item['descripcion'] == existe($sub_sub_modulo_sistema) ? 'text-zn-azul-opaco bg-gray-100' : 'text-zn-azul-letras' }} rounded-lg dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 group">
                    <span class="{{ $item['espacio'] > 0 ? 'ml-'.$item['espacio'] : 'ml-1' }} font-bold">{{ $item['descripcion'] }} </span>
                </a>

        @endif

        </li>
    <?php /* Si contiene contiene submenu se imprime el item y se recorre el submenu */ ?>
    @else

        <li>
            <a href="{{ ($item['ruta'] != '#' ? route($item['ruta']) : $item['ruta']) }}" class="flex items-center p-2 {{ $item['descripcion'] == existe($modulo_sistema) || $item['descripcion'] == existe($sub_modulo_sistema) || $item['descripcion'] == existe($sub_sub_modulo_sistema) ? 'text-zn-azul-opaco bg-gray-100' : 'text-zn-azul-letras' }} rounded-lg dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 group"  aria-controls="dropdown-pages-{{ $item['id']}}" data-collapse-toggle="dropdown-pages-{{ $item['id']}}" aria-expanded="true">
                <span class="{{ $item['espacio'] > 0 ? 'ml-'.$item['espacio'] : 'ml-1' }} flex-1 text-left whitespace-nowrap font-bold">{{ $item['descripcion'] }} </span>
                <svg aria-hidden="true" class="w-6 h-6 self-end" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </a>
            <ul id="dropdown-pages-{{ $item['id']}}" class="py-2 space-y-2">
                <?php /* Se recorre el submenu */ $recorrido = 0; ?>
                @foreach ($item['submenu'] as $submenu)

                    @if( $accesos_user[$submenu['modulo_id']]['acceso'] > 1  )
                
                        <?php /* Si el submenu no contiene Submenu, se imprime el item */ $recorrido++; ?>
                        @if ($submenu['submenu'] == [])
                        
                            <li>
                                <a href="{{ ($submenu['ruta'] != '#' ? route($submenu['ruta']) : $submenu['ruta']) }}" class="flex items-center p-2 {{ $submenu['descripcion'] == existe($modulo_sistema) || $submenu['descripcion'] == existe($sub_modulo_sistema) || $submenu['descripcion'] == existe($sub_sub_modulo_sistema) ? 'text-zn-azul-opaco bg-gray-100' : 'text-zn-azul-letras' }} rounded-lg dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 group">
                                <span class="ml-{{ $submenu['espacio'] }} 22">{{$submenu['espacio'] == 8 ? '- ' : ''}}{{ $submenu['descripcion'] }}</span>
                                </a>
                            </li>
                            <!-- <li><a href="{{ ($submenu['ruta'] != '#' ? route($submenu['ruta']) : $item['ruta']) }}" class="dropdown-item btn-load-gif {{ $recorrido == 1 ? 'arriba' : ''}}">{{ $submenu['descripcion'] }} </a></li> -->

                        <?php /* Si el submenu contiene Submenu, entre nuevamente en este archivo a imprimir los items del submenu, ademas se le suma 1 al nivel */ ?>
                        @else
                            @include('generales.menu-item', [ 'item' => $submenu, 'nivel'=>$nivel + 1 ])
                        @endif

                    @endif

                @endforeach
            </ul>
        </li>

    @endif
 @endif