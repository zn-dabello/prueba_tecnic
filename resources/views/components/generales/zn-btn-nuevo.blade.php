@props(['value', 'acciones', 'color'])
<a 
    @php $color = $color ?? 'bg-blue-900 ' @endphp
    {{ $attributes->merge(['class' => 'rounded-md  '.$color.' px-3 py-2 text-sm font-semibold text-white shadow-sm h hover:bg-opacity-75 block text-center text-white flex cursor-pointer py-1  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 btn-nuevo-registro']) }}
    href="{{ $acciones ?? '' }}" >

    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
    </svg>

    &nbsp;
    <span class="whitespace-nowrap"> {{ $value ?? 'Nuevo' }} </span>
</a>