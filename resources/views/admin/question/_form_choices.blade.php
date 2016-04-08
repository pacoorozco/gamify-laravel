<!-- choices -->
<div class="row form-group">
    <div class="col-sm-9">{!! Form::label('text[]', trans('admin/choice/model.text'), array('class' => 'control-label')) !!}</div>
    <div class="col-sm-3">{!! Form::label('points[]', trans('admin/choice/model.points'), array('class' => 'control-label')) !!}</div>
</div>

@foreach ($question->choices as $choice)
    <div class="row form-group cloneable">
        <div class="col-sm-9">
            {!! Form::text('text[]', $choice->text, array('class' => 'form-control')) !!}
        </div>
        <div class="col-sm-3">
            <div class="input-group">
                {!! Form::number('points[]', $choice->points, array('class' => 'form-control')) !!}
                <span class="input-group-btn">
                    <button type="button" class="btn btn-danger btn-remove">
                        <i class="fa fa-times fa fa-white"></i>
                    </button>
                </span>
            </div>
        </div>
    </div>
@endforeach

<div class="row form-group cloneable">
    <div class="col-sm-9">
        {!! Form::text('text[]', null, array('class' => 'form-control')) !!}
    </div>
    <div class="col-sm-3">
        <div class="input-group">
            {!! Form::number('points[]', null, array('class' => 'form-control')) !!}
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary btn-add">
                    <i class="fa fa-plus fa fa-white"></i>
                </button>
            </span>
        </div>
    </div>
</div>
<!-- ./ choices -->