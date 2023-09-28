<!-- @props(['name', 'options' =>[], 'selectedOptions' => []])

<select name="{{$name ?? 'InputSelect'}}" id="{{$name ?? 'InputSelect'}}"        
    @error($name)  
            {{ $attributes->merge(['class' => '!border !border-red-500 rounded']) }}
    @enderror

    {{ $attributes->merge(['class' => 'form-control form-input py-1 w-32 rounded']) }}
>
    <option value="">SELECCIONE</option>
    @foreach($options as $value => $label)
        <option value="{{ $value }}" isSelected($value)>{{ $label }}</option>
    @endforeach


</select> -->

@props([
    'options' => [],
    'selectedOptions' => []
])

<select {{ $attributes->merge(['class' => 'form-control']) }}>
    @foreach($options as $value => $label)
        <option value="{{ $value }}" isSelected($value)>{{ $label }}</option>
    @endforeach
</select>