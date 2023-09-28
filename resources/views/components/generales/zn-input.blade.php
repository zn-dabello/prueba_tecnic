@props(['type' => 'text', 'name', 'value' => null])

<input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
       
       @error($name)  
              {{ $attributes->merge(['class' => 'form-control !border !border-red-500 rounded']) }}
       @enderror

       {{ $attributes->merge(['class' => 'form-control form-input py-1 rounded']) }}

       value="{{ $value }}" {!! $attributes !!}>
