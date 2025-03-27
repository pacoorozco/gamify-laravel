@props([
    'label',
    'name' => '',
    'options' => [],
    'selectedKey' => '',
    'required' => false,
    'disabled' => false,
    'hidePlaceholderFromSelection' => false
    ])

<div class="form-group @error($name) has-error @enderror">
    <x-forms.label for="{{ \Illuminate\Support\Str::camel($name) }}">{{ $label }}</x-forms.label>
    <select name="{{ $name }}"
            id="{{ \Illuminate\Support\Str::camel($name) }}"
        {{ $attributes->merge(['class' => 'form-control'])->only(['class']) }}
        @required($required)
        @disabled($disabled)
    >
        @if($attributes->has('placeholder'))
            <option value=""
                    @if($hidePlaceholderFromSelection) hidden @endif>{{ $attributes->get('placeholder') }}</option>
        @endif
        @foreach($options as $key => $option)
            @if(is_array($option))
                <x-forms.select-optgroup label="{{ $key }}" :options="$option" selectedKey="{{ old($name, $selectedKey) }}"/>
            @else
                <x-forms.select-option key="{{ $key }}" label="{{ $option }}" selectedKey="{{ old($name, $selectedKey) }}"/>
            @endif
        @endforeach
    </select>
    @if($disabled)
        <x-forms.input-hidden name="{{ $name }}" value="{{ $selectedKey }}"/>
    @endif
    <x-forms.error name="{{ $name }}"></x-forms.error>
</div>
