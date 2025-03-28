@props([
    'name',
    'value',
    'label',
    'id',
    'help' => '',
    'checked' => false,
    'disabled' => false
    ])

@php
    $id = $id ?? \Illuminate\Support\Str::camel($name.$value);
@endphp

<div {{ $attributes->class(['radio', 'disabled' => $disabled]) }}>
        <input type="radio"
               name="{{ $name }}"
               id="{{ $id }}"
               value="{{ $value }}"
            @checked($checked)
            @if($help) aria-describedby="{{ $id . '_help' }}" @endif
        />
    <label for="{{ $id }}">
        {{ $label }}
        @if($help)
            <span id="{{ $id . '_help' }}" class="text-muted">
                {{ $help }}
            </span>
        @endif
    </label>
    <x-forms.error name="{{ $name }}"></x-forms.error>
</div>

