<a href="{{ route('admin.' . $model . '.show', $id) }}">
    <button type="button" class="btn btn-xs btn-info" title="{{ __('general.show') }}">
        <i class="fa fa-eye"></i>
    </button>
</a>
<a href="{{ route('admin.' . $model . '.edit', $id) }}">
    <button type="button" class="btn btn-xs btn-primary" title="{{ __('general.edit') }}">
        <i class="fa fa-edit"></i>
    </button>
</a>

