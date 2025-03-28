@props([
    'hasError' => false
    ])

<div {{ $attributes->class(['form-group', 'has-error' => $hasError]) }}>
    {{ $slot }}
</div>
