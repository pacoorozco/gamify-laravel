@props([
    'label' =>'',
    'name' => '',
    'value' => '',
    'help' => '',
    'type' => 'text',
    'required' => false,
    'readonly' => false,
    ])

<div class="form-group @error($name) has-error @enderror">
    <x-forms.label for="{{ \Illuminate\Support\Str::camel($name) }}">{{ $label }}</x-forms.label>
    <input id="{{ \Illuminate\Support\Str::camel($name) }}" name="{{ $name }}"
           type="{{ $type }}"
           @if($type == 'number')
               {{ $attributes }}
           @endif
           {{ $attributes->class(['form-control'])->only(['class', 'placeholder']) }}
           value="{{ old($name, $value) }}"
        @required($required)
        @readonly($readonly)

    />
    @if($help)
        <p class="text-muted">{{ $help }}</p>
    @endif
    <x-forms.error name="{{ $name }}"></x-forms.error>
</div>
