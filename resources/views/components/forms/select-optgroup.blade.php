@props([
    'label',
    'options' => [],
    'selectedKey' => ''
])

<optgroup label="{{ $label }}">
    @foreach($options as $key => $option)
        <option value="{{ $key }}" @selected($key == $selectedKey)>
            {{ $option }}
        </option>
    @endforeach
</optgroup>
