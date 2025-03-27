@props([
    'label',
    'name' => '',
    'value' => '',
    'required' => false,
    'readonly' => false
    ])

<div class="form-group @error($name) has-error @enderror">
    <x-forms.label for="{{ \Illuminate\Support\Str::camel($name) }}">{{ $label }}</x-forms.label>

    <textarea id="{{ \Illuminate\Support\Str::camel($name) }}"
              name="{{ $name }}"
              {{ $attributes->merge(['class' => 'form-control', 'rows' => '3', 'cols' => '50'])->only(['class', 'placeholder', 'rows', 'cols']) }}
                  @required($required)
                  @readonly($readonly)
        >{{ old($name, $value) }}</textarea>
    <x-forms.error name="{{ $name }}"></x-forms.error>
</div>
