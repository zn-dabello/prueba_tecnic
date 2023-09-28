@props(['value' => null])
<p id="file_input_help" 
    {{ $attributes->merge(['class' => 'mt-1 text-sm text-gray-500 dark:text-gray-300']) }}
    {!! $attributes !!}>
    {{ $value ?? 'SVG, PNG, JPG or GIF (MAX. 800x400px).' }}
</p>