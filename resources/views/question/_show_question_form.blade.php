<x-forms.form method="post"
              :action="route('questions.answer', ['q_hash' => $question->hash, 'slug' => $question->slug])">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">{{ $question->name }}</h2>
        </div>
        <div class="card-body">
            <div id="question_statement" class="mb-4">
                {{ $question->present()->statement }}
            </div>

            <fieldset id="choicesGroup" class="form-group">

                <legend>{{ __('question/messages.choices') }}</legend>

                @foreach($question->choices as $choice)
                    @if($question->type == 'single')
                        <x-forms.radio name="choices[]" label="{{ $choice->text }}" value="{{ $choice->id }}"/>
                    @else
                        <x-forms.checkbox name="choices[]" label="{{ $choice->text }}" value="{{ $choice->id }}"/>
                    @endif
                @endforeach
            </fieldset>

        </div>
        <div class="card-footer text-right">
            <x-forms.submit type="primary" :value="__('question/messages.send')"/>
        </div>
    </div>
</x-forms.form>

