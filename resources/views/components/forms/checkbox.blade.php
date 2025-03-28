@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'required' => false,
    'checked' => false
    ])

<div {{ $attributes->merge(['class' => 'checkbox']) }}>
    <label for="{{ \Illuminate\Support\Str::camel($name.$value) }}">
        <input type="checkbox" name="{{ $name }}"
               id="{{ \Illuminate\Support\Str::camel($name.$value) }}"
               @required($required)
               @checked($checked)
               value="{{ $value }}"

        >
        {{ $label }}
    </label>
    <x-forms.error name="{{ $name }}"></x-forms.error>
</div>
