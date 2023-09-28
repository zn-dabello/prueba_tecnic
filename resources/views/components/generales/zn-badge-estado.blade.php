@props(['texto'])
<div {{ $attributes->merge(['class' => 'zn-estado']) }}> 
    {{ $texto ?? 'Indefinido' }}
</div>