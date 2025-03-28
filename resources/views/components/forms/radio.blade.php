@props([
    'label',
    'id',
    'name' => '',
    'value' => '',
    'help' => '',
    'checked' => false,
    ])

<div class="radio">
    <x-forms.label for="{{ $id }}">
        <input id="{{ $id }}" name="{{ $name }}"
               type="radio"
               value="{{ $value }}"
            @checked($checked)
            @if($help) aria-describedby="{{ $id . '_help' }}" @endif
        />
        {{ $label }}
        @if($help)
            <span id="{{ $id . '_help' }}" class="text-muted">
                {{ $help }}
            </span>
        @endif
    </x-forms.label>
</div>

