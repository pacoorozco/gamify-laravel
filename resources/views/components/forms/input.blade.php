@props([
    'label',
    'name' => '',
    'value' => '',
    'help' => '',
    'type' => 'text',
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'sr-only' => false,
    ])

<div class="form-group">
    <x-forms.label for="{{ \Illuminate\Support\Str::camel($name) }}">{{ $label }}</x-forms.label>
    <input name="{{ $name }}" id="{{ \Illuminate\Support\Str::camel($name) }}"
           type="{{ $type }}"
           value="{{ old($name, $value) }}"
           @if($type == 'number')
               {{ $attributes->only(['min', 'max']) }}
           @endif
           @class([
                'form-control',
                'is-invalid' => $errors->has($name),
            ])
           @required($required)
           @readonly($readonly)
           @disabled($disabled)
           @error($name)
           aria-describedby="validation{{ \Illuminate\Support\Str::studly($name) }}Feedback"
        @enderror
    />
    @if($help)
        <p class="text-muted">{{ $help }}</p>
    @endif
    <x-forms.error name="{{ $name }}"></x-forms.error>
</div>
