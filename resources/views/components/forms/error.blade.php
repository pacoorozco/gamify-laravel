@props([
    'name',
    'id',
    ])

@error($name)
<span id="{{ $id ?? 'validation' . \Illuminate\Support\Str::studly($name) . 'Feedback' }}"
      {{ $attributes->class(['error invalid-feedback']) }}>
    {{ $message }}
</span>
@enderror
