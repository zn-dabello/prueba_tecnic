@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm text-gray-600 font-bold mr-2 flex']) }}>
    {{ $value ?? $slot }} <span class="block text-sm font-bold text-red-500 justify-self-start ml-2"> ( * )</span>
</label> 
