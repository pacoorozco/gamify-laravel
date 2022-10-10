<!-- choices -->
<fieldset class="choices">
    <legend>{{ __('admin/question/model.choices_section') }}</legend>
    <p class="text-muted">
        {{ __('admin/question/model.choices_help') }}
        <strong>{{ __('admin/question/model.choice_score_help') }}</strong>
    </p>

    @error('choices')
    <div class="form-group has-error">
        <span class="help-block">{{ $errors->first('choices', ':message') }}</span>
    </div>
    @enderror

    <div class="choices-wrapper">
        <div class="choices-container">
            @foreach(old('choices', (isset($question) ? $question->choices->toArray() : [])) as $choice)
                <div class="row choices-row">
                    <div class="col-sm-9 form-group {{ $errors->has('choices.'. $loop->index .'.*') ? 'has-error' : '' }}">
                        {!! Form::label('choices['. $loop->index .'][text]', __('admin/question/model.choice_text'), ['class' => 'control-label']) !!}
                        {!! Form::text('choices['. $loop->index .'][text]', $choice['text'], ['class' => 'form-control', 'placeholder' => __('admin/question/model.choice_text_help')]) !!}
                        <span class="help-block">{{ $errors->first('choices.'. $loop->index .'.*', ':message') }}</span>
                    </div>
                    <div class="col-sm-3 form-group {{ $errors->has('choices.'. $loop->index .'.*') ? 'has-error' : '' }}">
                        {!! Form::label('choices['. $loop->index .'][score]', __('admin/question/model.choice_score'), ['class' => 'control-label']) !!}
                        <div class="input-group">
                            {!! Form::number('choices['. $loop->index .'][score]', $choice['score'], ['class' => 'form-control']) !!}
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default remove" title="{{ __('button.remove_choice') }}">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="row form-group choices-template choices-row">
                <div class="col-sm-9">
                    {!! Form::label('choices[%%choice-count-placeholder%%][text]', __('admin/question/model.choice_text'), ['class' => 'control-label']) !!}
                    {!! Form::text('choices[%%choice-count-placeholder%%][text]', '', ['class' => 'form-control', 'placeholder' => __('admin/question/model.choice_text_help')]) !!}
                </div>
                <div class="col-sm-3">
                    {!! Form::label('choices[%%choice-count-placeholder%%][score]', __('admin/question/model.choice_score'), ['class' => 'control-label']) !!}
                    <div class="input-group">
                        {!! Form::number('choices[%%choice-count-placeholder%%][score]', '', ['class' => 'form-control']) !!}
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default remove" title="{{ __('button.remove_choice') }}">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-row">
            <button type="button" class="btn btn-default pull-right add">
                <i class="fa fa-plus"></i> {{ __('button.add_new_choice') }}
            </button>
        </div>
    </div>
</fieldset>
<!-- ./ choices -->

@push('scripts')
    <script
        src="{{ asset('vendor/repeatable-fields/repeatable-fields.min.js') }}"></script>

    <script>
        $(function () {
            $('.choices').each(function () {
                $(this).repeatable_fields({
                    wrapper: '.choices-wrapper',
                    container: '.choices-container',
                    row: '.choices-row',
                    template: '.choices-template',
                    row_count_placeholder: '%%choice-count-placeholder%%',
                });
            });
        });
    </script>
@endpush
