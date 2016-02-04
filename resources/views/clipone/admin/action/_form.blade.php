{{-- Create / Edit Question Action Form --}}

@if (isset($action))
{!! Form::model($action, array(
            'route' => array('admin.questions.actions.update', $question, $action),
            'method' => 'put'
            )) !!}
@else
{!! Form::open(array(
            'route' => array('admin.questions.actions.store', $question),
            'method' => 'post'
            )) !!}
@endif

<div class="row">
    <div class="col-xs-12">

        <!-- action -->
        <div class="form-group {{ $errors->has('badge_id') ? 'has-error' : '' }}">
            {!! Form::label('points', trans('admin/action/model.action'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('badge_id', $question->getAvailableActions(), null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('badge_id', ':message') }}</span>
            </div>
        </div>
        <!-- ./ action -->

        <!-- when -->
        <div class="form-group {{ $errors->has('when') ? 'has-error' : '' }}">
            {!! Form::label('when', trans('admin/action/model.when'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('when', array('always' => 'Always', 'correct' => 'Correct', 'incorrect' => 'Incorrect'), null, array('class' => 'form-control')) !!}
                {{ $errors->first('when', '<span class="help-inline">:message</span>') }}
            </div>
        </div>
        <!-- ./ when -->


    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <!-- Form Actions -->
        <div class="form-group">
            <div class="controls">
                <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{ trans('general.back') }}</a>
                {!! Form::button(trans('button.save'), array('type' => 'submit', 'class' => 'btn btn-success')) !!}
            </div>
        </div>
        <!-- ./ form actions -->
    </div>
</div>

{!! Form::close() !!}