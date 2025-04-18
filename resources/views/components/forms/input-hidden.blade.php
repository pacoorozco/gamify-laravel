@props([
    'id' => '',
    'name',
     'value'
     ])

<input id="{{ $id ?? $name }}" name="{{ $name }}" type="hidden" value="{{ $value }}">
