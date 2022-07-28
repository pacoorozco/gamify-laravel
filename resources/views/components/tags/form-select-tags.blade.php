<select
    multiple="multiple"
    id="{{ $name }}"
    name="{{ $name . '[]' }}"
    {{ $attributes }}
>
    @foreach($availableTags as $tag)
        <option value="{{ $tag }}" @selected($isSelected($tag))>{{ $tag }}</option>
    @endforeach
</select>

@pushOnce('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/AdminLTE/plugins/select2/css/select2.min.css') }}">
@endPushOnce

@pushOnce('scripts')
    <script src="{{ asset('vendor/AdminLTE/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        const selectedTags = [
                @foreach($selectedTags as $tag)
            {
                id: '{{ $tag }}',
                text: '{{ $tag }}',
                selected: true
            },
            @endforeach
        ];

        $(function () {
            $("#{{ $name }}").select2({
                tags: true,
                placeholder: "{{ $placeholder }}",
                tokenSeparators: [',', ' '],
                allowClear: true,
                width: "100%",
                data: selectedTags,
            });
        });
    </script>
@endPushOnce
