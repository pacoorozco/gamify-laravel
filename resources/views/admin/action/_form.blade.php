{{-- Create Question Action Form --}}

{!! Form::open(array(
            'route' => array('admin.questions.actions.store', $question),
            'method' => 'post'
            )) !!}

<div class="box box-solid">
    <div class="box-body">

        <!-- action -->
        <div class="form-group {{ $errors->has('badge_id') ? 'has-error' : '' }}">
            {!! Form::label('points', trans('admin/action/model.action'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('badge_id', $availableActions, null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('badge_id', ':message') }}</span>
            </div>
        </div>
        <!-- ./ action -->

        <!-- when -->
        <div class="form-group {{ $errors->has('when') ? 'has-error' : '' }}">
            {!! Form::label('when', trans('admin/action/model.when'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('when', trans('admin/action/model.when_values'), null, array('class' => 'form-control')) !!}
                {{ $errors->first('when', '<span class="help-inline">:message</span>') }}
            </div>
        </div>
        <!-- ./ when -->

    </div>
    <div class="box-footer">
        <!-- Form Actions -->
                <a href="{{ route('admin.questions.edit', $question) }}">
                    <button type="button" class="btn btn-primary">
                        <i class="fa fa-arrow-left"></i> {{ trans('general.back') }}
                    </button>
                </a>
                {!! Form::button(trans('button.save'), array('type' => 'submit', 'class' => 'btn btn-success')) !!}
        <!-- ./ form actions -->
    </div>
</div>

{!! Form::close() !!}