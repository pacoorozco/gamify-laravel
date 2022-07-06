<!-- actions -->
@if(count($question->getAvailableActions()) > 0)
    <a href="{{ route('admin.questions.actions.create', $question) }}" class="btn btn-primary">
        <i class="fa fa-plus"></i> {{ __('admin/action/title.create_new') }}
    </a>


    <table class="table table-hover">
        <tr>
            <th>{{ __('admin/action/table.action') }}</th>
            <th>{{ __('admin/action/table.when') }}</th>
            <th>{{ __('admin/action/table.actions') }}</th>
        </tr>
        @foreach ($question->actions as $action)
            <tr>
                <td>{!! Form::select('badge_id[]', $availableActions, $action->id, ['class' => 'form-control']) !!}</td>
                <td>{{ __('admin/action/table.when_values.' . $action->when) }}</td>
                <td>
                    <a href="{{ route('admin.questions.actions.destroy', [$question, $action]) }}"
                       rel="nofollow" data-method="delete"
                       data-confirm="{{ __('admin/action/messages.confirm_delete') }}">
                        <button type="button" class="btn btn-xs btn-danger" data-toggle="tooltip"
                                data-placement="top" title="{{ __('general.delete') }}">
                            <i class="fa fa-times fa fa-white"></i>
                        </button>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
@endif
<!-- ./ actions -->
