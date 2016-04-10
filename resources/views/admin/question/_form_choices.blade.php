<!-- choices -->
<div class="row form-group">
    <div class="col-sm-9">
        {!! Form::label('choice_text[]', trans('admin/question/model.choice_text'), array('class' => 'control-label')) !!}
    </div>
    <div class="col-sm-3">
        {!! Form::label('choice_points[]', trans('admin/question/model.choice_points'), array('class' => 'control-label')) !!}
    </div>
</div>

@if (isset($question))
    @foreach ($question->choices as $choice)
        <div class="row form-group cloneable">
            <div class="col-sm-9">
                {!! Form::text('choice_text[]', $choice->text, array('class' => 'form-control')) !!}
            </div>
            <div class="col-sm-3">
                <div class="input-group">
                    {!! Form::number('choice_points[]', $choice->points, array('class' => 'form-control')) !!}
                    <span class="input-group-btn">
                    <button type="button" class="btn btn-danger btn-remove">
                        <i class="fa fa-times fa fa-white"></i>
                    </button>
                </span>
                </div>
            </div>
        </div>
    @endforeach
@endif

<div class="row form-group cloneable">
    <div class="col-sm-9">
        {!! Form::text('choice_text[]', null, array('class' => 'form-control')) !!}
    </div>
    <div class="col-sm-3">
        <div class="input-group">
            {!! Form::number('choice_points[]', null, array('class' => 'form-control')) !!}
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary btn-add">
                    <i class="fa fa-plus fa fa-white"></i>
                </button>
            </span>
        </div>
    </div>
</div>
<!-- ./ choices -->