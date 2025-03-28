@props(['name'])
@error($name)
<span {{ $attributes->class(['help-block']) }}>{{ $message }}</span>
@enderror
