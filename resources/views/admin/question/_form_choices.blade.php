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
                    <div class="col-sm-9 form-group @error('choices.'. $loop->index .'.*') has-error @enderror">
                        <label for="{{ 'choices['. $loop->index .'][text]' }}" class="control-label">
                            {{ __('admin/question/model.choice_text') }}
                        </label>
                        <input id="{{ 'choices['. $loop->index .'][text]' }}"
                               name="{{ 'choices['. $loop->index .'][text]' }}"
                               type="text"
                               placeholder="{{ __('admin/question/model.choice_text_help') }}"
                               class="form-control"
                               value="{{ old('choices['. $loop->index .'][score]', $choice['text']) }}"
                        />
                        <x-forms.error name="{{ 'choices.'. $loop->index .'.*' }}"></x-forms.error>
                    </div>
                    <div
                        class="col-sm-3 form-group {{ $errors->has('choices.'. $loop->index .'.*') ? 'has-error' : '' }}">
                        <label for="{{ 'choices['. $loop->index .'][score]' }}" class="control-label">
                            {{ __('admin/question/model.choice_score') }}
                        </label>
                        <div class="input-group">
                            <input id="{{ 'choices['. $loop->index .'][score]' }}"
                                   name="{{ 'choices['. $loop->index .'][score]' }}"
                                   type="number"
                                   class="form-control"
                                   value="{{ old('choices['. $loop->index .'][score]', $choice['score']) }}"
                            />
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default remove"
                                        title="{{ __('button.remove_choice') }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="row form-group choices-template choices-row">
                <div class="col-sm-9">
                    <label for="choices[%%choice-count-placeholder%%][text]" class="control-label">
                        {{ __('admin/question/model.choice_text') }}
                    </label>
                    <input id="choices[%%choice-count-placeholder%%][text]"
                           name="choices[%%choice-count-placeholder%%][text]"
                           type="text"
                           class="form-control"
                           placeholder="{{ __('admin/question/model.choice_text_help') }}"
                    />
                </div>
                <div class="col-sm-3">
                    <label for="choices[%%choice-count-placeholder%%][score]" class="control-label">
                        {{ __('admin/question/model.choice_score') }}
                    </label>
                    <div class="input-group">
                        <input id="choices[%%choice-count-placeholder%%][score]"
                               name="choices[%%choice-count-placeholder%%][score]"
                               type="number"
                               class="form-control"
                        />
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default remove"
                                    title="{{ __('button.remove_choice') }}">
                                    <i class="bi bi-trash"></i>
                            </button>
                    </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-row">
            <button type="button" class="btn btn-default pull-right add">
                <i class="bi bi-plus"></i> {{ __('button.add_new_choice') }}
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
