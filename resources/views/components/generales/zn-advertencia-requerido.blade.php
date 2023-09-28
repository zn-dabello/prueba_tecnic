@props(['value'])

<div {{ $attributes->merge(['class' => 'text-sm font-semibold text-red-500']) }}>
{{ $value ?? '(*) Datos Obligatorios' }}
</div>