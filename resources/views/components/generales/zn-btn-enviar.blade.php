@props(['value', 'type'])
<button type="{{ $type ?? 'submit' }}"
    {{ $attributes->merge(['class' => 'rounded-md bg-blue-700 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-6700 flex']) }} >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
    </svg>
    &nbsp;
    <span class="whitespace-nowrap"> {{ $value ?? 'Guardar' }}</span>
</button>
