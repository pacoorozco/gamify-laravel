@props([
    'label',
    'name' => '',
    'value' => '',
    'help' => '',
    'type' => 'text',
    'required' => false,
    'readonly' => false,
    'disabled' => false,
    'prepend' => '',
    'append' => '',
    ])

<div class="form-group">
    <x-forms.label for="{{ \Illuminate\Support\Str::camel($name) }}">{{ $label }}</x-forms.label>
    <div class="input-group">
        @if($prepend)
            <div class="input-group-prepend">
                <span class="input-group-text">{!! $prepend !!}</span>
            </div>
        @endif
        <input name="{{ $name }}" id="{{ \Illuminate\Support\Str::camel($name) }}"
               type="{{ $type }}"
               value="{{ old($name, $value) }}"
               @if($type == 'number')
                   {{ $attributes->only(['min', 'max']) }}
               @endif
               {{ $attributes->class([
                'form-control',
                'is-invalid' => $errors->has($name),
            ]) }}
               @required($required)
               @readonly($readonly)
               @disabled($disabled)
               @error($name)
               aria-describedby="validation{{ \Illuminate\Support\Str::studly($name) }}Feedback"
            @enderror
        />
        @if($append)
            <div class="input-group-append">
                <span class="input-group-text">{!! $append !!}</span>
            </div>
        @endif
    </div>
    @if($help)
        <small class="form-text text-muted">{{ $help }}</small>
    @endif
    <x-forms.error name="{{ $name }}"></x-forms.error>
</div>
