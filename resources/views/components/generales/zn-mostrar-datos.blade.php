@props(['value'])
<p
    {{ $attributes->merge(['class' => 'text-gray-500 text-justify']) }}
>
{{ $value ?? '' }}
</p>