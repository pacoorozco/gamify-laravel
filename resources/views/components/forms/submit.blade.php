@props([
    'type' => 'success',
    'value' => 'Submit'
    ])


<button type="submit" {{ $attributes->merge(['class' => 'btn btn-'.$type]) }}>
    {{ $value }}
</button>

