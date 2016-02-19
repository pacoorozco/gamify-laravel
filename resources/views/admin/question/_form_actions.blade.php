<!-- actions -->
<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-external-link-square"></i>
        {{ trans('admin/action/title.current_actions') }}
    </div><!-- ./ panel-header -->
    <div class="panel-body">
        <p>
            @if(count($question->getAvailableActions()) > 0)
                <a href="{{ route('admin.questions.actions.create', $question) }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> {{ trans('admin/action/title.create_new') }}
                </a>
            @endif
        </p>
        @if (count($question->actions) > 0)
            <table class="table table-hover">
                <tr>
                    <th>{{ trans('admin/action/table.action') }}</th>
                    <th>{{ trans('admin/action/table.when') }}</th>
                    <th>{{ trans('admin/action/table.actions') }}</th>
                </tr>
                @foreach ($question->actions as $action)
                    <tr>
                        <td>{{ $action->getName() }}</td>
                        <td>{{ trans('admin/action/table.when_values.' . $action->when) }}</td>
                        <td>
                            <a href="{{ route('admin.questions.actions.destroy', array($question, $action)) }}"
                               rel="nofollow" data-method="delete"
                               data-confirm="{{ trans('admin/action/messages.confirm_delete') }}">
                                <button type="button" class="btn btn-xs btn-danger" data-toggle="tooltip"
                                        data-placement="top" title="{{ trans('general.delete') }}">
                                    <i class="fa fa-times fa fa-white"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
    </div>
</div>
<!-- ./ actions -->