<!-- actions -->
@if (count($question->actions) > 0)
<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-external-link-square"></i>
        {{ trans('admin/action/title.current_actions') }}
    </div><!-- ./ panel-header -->
    <div class="panel-body">
        <p>
            <a href="{{ route('admin.questions.actions.create', $question) }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> {{ trans('admin/action/title.create_new') }}
            </a>
        </p>
        <table class="table table-hover">
            <tr>
                <th>{{ trans('admin/action/table.action') }}</th>
                <th>{{ trans('admin/action/table.when') }}</th>
                <th>{{ trans('admin/action/table.actions') }}</th>
            </tr>
            @foreach ($question->actions as $action)
            <tr>
                <td>{{ $action->badge_id }}</td>
                <td>{{ $action->when }}</td>
                <td>
                    <a href="{{ route('admin.questions.actions.edit', array($question, $action)) }}" class="btn btn-xs btn-teal tooltips" data-placement="top" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                    <a href="{{ route('admin.questions.actions.destroy', array($question, $action)) }}" rel='nofollow'
                       data-method='delete' data-confirm='{{ trans('admin/action/messages.confirm_delete') }}' class="btn btn-xs btn-bricky tooltips" data-placement="top" data-original-title="Remove"><i class="fa fa-times fa fa-white"></i></a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@else
<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-external-link-square"></i>
        {{ trans('admin/action/title.current_actions') }}
    </div><!-- ./ panel-header -->
    <div class="panel-body">
        <div class="alert alert-block alert-danger">
            <h4 class="alert-heading"><i class="fa fa-times-circle"></i> {{ trans('admin/action/title.not_enough_actions') }}</h4>
            <p>{{ trans('admin/action/messages.add_more_actions') }}</p>
            <p>
                <a href="{{ route('admin.questions.actions.create', $question) }}" class="btn btn-success">
                    <i class="fa fa-plus"></i> {{ trans('admin/action/title.create_new') }}
                </a>
            </p>
        </div>
    </div>
</div>
@endif
<!-- ./ actions -->