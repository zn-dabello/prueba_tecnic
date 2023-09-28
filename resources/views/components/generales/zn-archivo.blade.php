@props(['name' => 'inputArchivo', 'value' => null, 'tipo' => 'registrar', 'descripcion' => 'archivo'])
@php $borde = $tipo != 'actualizar' ? 'rounded-lg' : ' rounded-s-lg'; @endphp
<div class="flex input-{{ $descripcion }}">
        <input 
        aria-describedby="file_input_help"
        type="file"
        name="{{ $name ?? 'inputArchivo' }}"
        id="{{ $name ?? 'inputArchivo' }}"
        value="{{ $value ?? ''}}"

        @error($name)  
                {{ $attributes->merge(['class' => 'block w-full text-sm text-gray-900 border border-gray-300 '. $borde .' cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:placeholder-gray-400 !border !border-red-500 rounded']) }}
        @enderror

        {{ $attributes->merge(['class' => 'block w-full text-sm text-gray-900 border border-gray-300 '. $borde .' cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400']) }}

        >
        @if( $tipo == 'actualizar')
                <button data-ver=0 type="button" title="Cancelar" class="btn-mostrar-{{ $descripcion ?? 'archivo' }} hidden p-2 text-sm font-medium text-white bg-gray-900 rounded-r-md border border-blue-900 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="pass-ver w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="sr-only">Ver</span>
                </button>
        @endif
</div>
