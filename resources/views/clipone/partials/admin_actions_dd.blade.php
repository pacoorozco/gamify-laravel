<div class="btn-group">
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
        {{ trans('button.actions') }}
    </button>
    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="{{ URL::route('admin.' . $model . '.show', $id) }}">{{ trans('button.show') }}</a></li>
        <li><a href="{{ URL::route('admin.' . $model . '.edit', $id) }}">{{ trans('button.edit') }}</a></li>
        <li><a href="{{ URL::route('admin.' . $model . '.delete', $id) }}">{{ trans('button.delete') }}</a></li>
    </ul>
</div>

