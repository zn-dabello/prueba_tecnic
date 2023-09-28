@props(['value', 'tipo' =>'registrar', 'descripcion'])

<div class="bock-descripcion-{{ $descripcion ?? 'archivo' }} {{ $tipo == 'registrar' ? 'hidden' : '' }}">
    <div class="relative w-full h-10 form-control hover:text-blue-500 {{ $tipo == 'registrar' ? 'hidden' : '' }}">
        {!! $value ?? ''  !!}
        <button data-ver=0 type="button" class="btn-{{ $descripcion ?? 'archivo' }} absolute top-0 right-0 h-full p-2.5 text-sm font-medium text-white bg-gray-900 rounded-r-md border border-blue-900 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="pass-ver w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
            <span class="sr-only">Ver</span>
        </button>
    </div>
</div>