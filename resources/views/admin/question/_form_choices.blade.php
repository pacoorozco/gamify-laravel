<!-- choices -->
<div class="row form-group">
    <div class="col-sm-9">
        {!! Form::label('choice_text[]', __('admin/question/model.choice_text'), ['class' => 'control-label']) !!}
    </div>
    <div class="col-sm-3">
        {!! Form::label('choice_score[]', __('admin/question/model.choice_score'), ['class' => 'control-label']) !!}
    </div>
</div>

@isset($question)
    @foreach ($question->choices as $choice)
        <div class="row form-group cloneable">
            <div class="col-sm-9">
                {!! Form::text('choice_text[]', $choice->text, ['class' => 'form-control', 'placeholder' => __('admin/question/model.choice_text_help')]) !!}
            </div>
            <div class="col-sm-3">
                <div class="input-group">
                    {!! Form::number('choice_score[]', $choice->score, ['class' => 'form-control']) !!}
                    <span class="input-group-btn">
                    <button type="button" class="btn btn-danger btn-remove">
                        <i class="fa fa-trash fa fa-white"></i>
                    </button>
                </span>
                </div>
            </div>
        </div>
    @endforeach
@endisset

<div class="row form-group cloneable">
    <div class="col-sm-9">
        {!! Form::text('choice_text[]', null, ['class' => 'form-control', 'placeholder' => __('admin/question/model.choice_text_help')]) !!}
    </div>
    <div class="col-sm-3">
        <div class="input-group">
            {!! Form::number('choice_score[]', null, ['class' => 'form-control']) !!}
            <span class="input-group-btn">
                <button type="button" class="btn btn-primary btn-add">
                    <i class="fa fa-plus fa fa-white"></i>
                </button>
            </span>
        </div>
    </div>
</div>

<div class="form-group">
    <span class="text-muted"><i class="fa fa-info-circle"></i> @lang('admin/question/model.choice_score_help')</span>
</div>
<!-- ./ choices -->

@push('scripts')
    <script>
        $(document).on('click', '.btn-add', function (event) {
            event.preventDefault();

            let field = $(this).closest('.cloneable');
            let field_new = field.clone();

            $(this)
                .toggleClass('btn-primary')
                .toggleClass('btn-add')
                .toggleClass('btn-danger')
                .toggleClass('btn-remove')
                .html('<i class="fa fa-trash"></i>');

            field_new.find('input').val('');
            field_new.insertAfter(field);
        });

        $(document).on('click', '.btn-remove', function (event) {
            event.preventDefault();
            $(this).closest('.cloneable').remove();
        });
    </script>
@endpush
