@props(['name', 'value' => null, 'valor' => null])

<select name="{{ $name }}" id="{{ $name }}"
       
       @error($name)  
              {{ $attributes->merge(['class' => '!border !border-red-500 rounded']) }}
       @enderror

       {{ $attributes->merge(['class' => 'form-control form-input py-1 w-32 rounded']) }}

       value="{{ $value }}" {!! $attributes !!}>
    
    <option value="2" {{ $value == 2 ? 'selected' : '' }} >2</option>
    <option class="indicador-tel-9" value="9"  {{ $value == 2 ? 'selected' : '' }} >9</option>
    <option value="32"  {{ $value == 32 ? 'selected' : '' }}>32</option>
    <option value="33"  {{ $value == 33 ? 'selected' : '' }}>33</option>
    <option value="34"  {{ $value == 34 ? 'selected' : '' }}>34</option>
    <option value="35"  {{ $value == 35 ? 'selected' : '' }}>35</option>
    <option value="41"  {{ $value == 41 ? 'selected' : '' }}>41</option>
    <option value="42"  {{ $value == 42 ? 'selected' : '' }}>42</option>
    <option value="43"  {{ $value == 43 ? 'selected' : '' }}>43</option>
    <option value="45"  {{ $value == 45 ? 'selected' : '' }}>45</option>
    <option value="51"  {{ $value == 51 ? 'selected' : '' }}>51</option>
    <option value="52"  {{ $value == 52 ? 'selected' : '' }}>52</option>
    <option value="53"  {{ $value == 53 ? 'selected' : '' }}>53</option>
    <option value="55"  {{ $value == 55 ? 'selected' : '' }}>55</option>
    <option value="57"  {{ $value == 57 ? 'selected' : '' }}>57</option>
    <option value="58"  {{ $value == 58 ? 'selected' : '' }}>58</option>
    <option value="61"  {{ $value == 61 ? 'selected' : '' }}>61</option>
    <option value="63"  {{ $value == 63 ? 'selected' : '' }}>63</option>
    <option value="64"  {{ $value == 64 ? 'selected' : '' }}>64</option>
    <option value="65"  {{ $value == 65 ? 'selected' : '' }}>65</option>
    <option value="67"  {{ $value == 67 ? 'selected' : '' }}>67</option>
    <option value="71"  {{ $value == 71 ? 'selected' : '' }}>71</option>
    <option value="72"  {{ $value == 72 ? 'selected' : '' }}>72</option>
    <option value="73"  {{ $value == 73 ? 'selected' : '' }}>73</option>
    <option value="75"  {{ $value == 75 ? 'selected' : '' }}>75</option>

</select> 