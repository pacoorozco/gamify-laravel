<!-- actions -->
<div class="row">
    <div class="col-xs-7">
        {{ trans('admin/action/table.action') }}
    </div>
    <div class="col-xs-4">
        {{ trans('admin/action/table.when') }}
    </div>
    <div class="col-xs-1">
    </div>
</div>
{{-- Print fields for added actions --}}
@foreach ($question->actions as $action)
    <div class="row">
        <div class="col-xs-7">
            {!! Form::select('badge_id[]', $availableActions, $action->id, array('class' => 'form-control')) !!}
        </div>
        <div class="col-xs-4">
            {!! Form::select('when[]', trans('admin/action/model.when_values'), $action->when, array('class' => 'form-control')) !!}
        </div>
        <div class="col-xs-1">
            <button type="button" class="btn btn-xs btn-danger btn-remove"
                    data-toggle="tooltip" data-placement="top" title="{{ trans('general.remove') }}"><i
                        class="fa fa-minus"></i>
            </button>
        </div>
    </div>
@endforeach
{{-- Print fields for a new action --}}
<div class="row">
    <div class="col-xs-7">
        {!! Form::select('badge_id[]', $availableActions, null, array('class' => 'form-control')) !!}
    </div>
    <div class="col-xs-4">
        {!! Form::select('when[]', trans('admin/action/model.when_values'), null, array('class' => 'form-control')) !!}
    </div>
    <div class="col-xs-1">
        <button type="button" class="btn btn-xs btn-primary"
                data-toggle="tooltip" data-placement="top" title="{{ trans('general.add') }}"><i
                    class="fa fa-plus"></i>
        </button>
    </div>
</div>
<!-- ./ actions -->