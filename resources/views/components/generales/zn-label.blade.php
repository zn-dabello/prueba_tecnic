@props(['value', 'requerido' =>'false'])

<label {{ $attributes->merge(['class' => 'block text-sm text-gray-600 font-bold mr-2 my-1 flex']) }}>
    {{ $value ?? $slot }} 
    {!! $requerido == 'false' ? '' : '<span class="block text-sm text-gray-700 font-bold text-red-500 justify-self-start ml-2"> ( * )</span>' !!}
    
</label> 
