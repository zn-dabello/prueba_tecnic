
<textarea name="{{ $name }}" id="{{ $name }}"
       @error($name)  
              {{ $attributes->merge(['class' => '!border !border-red-500 rounded']) }}
       @enderror
       
       {{ $attributes->merge(['class' => 'form-control form-textarea py-2 rounded w-full']) }}>{{ $value ?? '' }}</textarea>

