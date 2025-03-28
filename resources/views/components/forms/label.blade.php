@props([
    'for',
    'value'
])

<label
    {{ $attributes->class(['control-label']) }}
    for="{{ $for }}"
>
    {{ $value ?? $slot }}

</label>
