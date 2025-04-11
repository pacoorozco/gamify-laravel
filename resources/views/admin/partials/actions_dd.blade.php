<a href="{{ route('admin.' . $model . '.show', $id) }}">
    <button type="button" class="btn btn-xs btn-info" title="{{ __('general.show') }}">
        <i class="bi bi-eye-fill"></i>
    </button>
</a>
<a href="{{ route('admin.' . $model . '.edit', $id) }}">
    <button type="button" class="btn btn-xs btn-primary" title="{{ __('general.edit') }}">
        <i class="bi bi-pencil-square"></i>
    </button>
</a>

