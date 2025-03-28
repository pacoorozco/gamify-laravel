<x-forms.form method="post"
              :action="route('questions.answer', ['q_hash' => $question->hash, 'slug' => $question->slug])">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $question->name }}</h3>
        </div>
        <div class="box-body">
            <div id="question_statement">
                {{ $question->present()->statement }}
            </div>

            <fieldset id="choicesGroup">
                <p>
                    {{ __('question/messages.choices') }}
                </p>
                @foreach($question->choices as $choice)
                    <div class="form-group">
                        @if($question->type == 'single')
                            <x-forms.radio name="choices[]" label="{{ $choice->text }}" value="{{ $choice->id }}"
                                           class="icheck"/>
                        @else
                            <x-forms.checkbox name="choices[]" label="{{ $choice->text }}" value="{{ $choice->id }}"
                                              class="icheck"/>
                        @endif
                    </div>
                @endforeach
            </fieldset>

        </div>
        <div class="box-footer">
            <x-forms.submit type="primary" :value="__('question/messages.send')" id="btnSubmit"/>
        </div>
    </div>
</x-forms.form>


@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/AdminLTE/plugins/iCheck/square/blue.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('vendor/AdminLTE/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });
        });
    </script>
@endpush
