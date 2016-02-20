{{-- Create / Edit Question Choice Form --}}

@if (isset($choice))
    {!! Form::model($choice, array(
                'route' => array('admin.questions.choices.update', $question, $choice),
                'method' => 'put'
                )) !!}
@else
    {!! Form::open(array(
                'route' => array('admin.questions.choices.store', $question),
                'method' => 'post'
                )) !!}
@endif

<div class="box box-solid">
    <div class="box-body">
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
    <div class="box-footer">
        <!-- form actions -->
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