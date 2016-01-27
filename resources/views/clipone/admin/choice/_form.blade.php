{{-- Create / Edit Question Choice Form --}}

@if (isset($choice))
{!! Form::model($choice, array(
            'route' => array('admin.questions.choices.update', $question, $choice),
            'method' => 'put',
            'files' => true
            )) !!}
@else
{!! Form::open(array(
            'route' => array('admin.questions.choices.store', $question),
            'method' => 'post',
            'files' => true
            )) !!}
@endif

<div class="row">
    <div class="col-xs-12">

        <!-- text -->
        <div class="form-group {{ $errors->has('text') ? 'has-error' : '' }}">
            {!! Form::label('text', trans('admin/choice/model.text'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('text', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('text', ':message') }}</span>
            </div>
        </div>
        <!-- ./ text -->

        <!-- points -->
        <div class="form-group {{ $errors->has('points') ? 'has-error' : '' }}">
            {!! Form::label('points', trans('admin/choice/model.points'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::number('points', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('points', ':message') }}</span>
            </div>
        </div>
        <!-- ./ points -->

        <!-- correct -->
        <div class="form-group {{ $errors->has('correct') ? 'has-error' : '' }}">
            {!! Form::label('correct', trans('admin/choice/model.correct'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('correct', array('0' => trans('general.no'), '1' => trans('general.yes')), null, array('class' => 'form-control')) !!}
                {{ $errors->first('correct', '<span class="help-inline">:message</span>') }}
            </div>
        </div>
        <!-- ./ correct -->


    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <!-- Form Actions -->
        <div class="form-group">
            <div class="controls">
                <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-primary">{{ trans('button.back') }}</a>
                {!! Form::button(trans('button.save'), array('type' => 'submit', 'class' => 'btn btn-success')) !!}
            </div>
        </div>
        <!-- ./ form actions -->
    </div>
</div>

{!! Form::close() !!}