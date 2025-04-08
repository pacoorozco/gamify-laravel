@props(['name'])

@error($name)
<span id="validation{{ \Illuminate\Support\Str::studly($name) }}Feedback"
      {{ $attributes->class(['error invalid-feedback']) }}>
    {{ $message }}
</span>
@enderror
