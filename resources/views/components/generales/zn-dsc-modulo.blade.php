@props(['value'])

<h3 {{ $attributes->merge(['class' => 'text-2xl font-semibold leading-10 text-zn-azul-letras border-b-4 border-gray-300 mb-2 mx-1']) }} >
    {{ $value ?? 'Módulo' }}
</h3>