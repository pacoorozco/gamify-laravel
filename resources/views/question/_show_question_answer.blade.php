<div class="card">
    <div class="card-header">
        <h2 class="card-title">{{ $question->name }}</h2>
    </div>
    <div class="card-body">
        <div id="question_statement" class="mb-4">
            {{ $question->present()->statement }}
        </div>

        @if($question->solution)
            <div id="question_explanation" class="bg-success mb-4 p-4">
                <h3>{{ __('question/messages.explained_answer') }}</h3>
                <div class="mb-2">
                    {{ $question->present()->explanation }}
                </div>
            </div>
        @endif

        <h3 class="mb-4">
            @if($question->type == 'single')
                {{ __('question/messages.single_choice') }}
            @else
                {{ __('question/messages.multiple_choices') }}
            @endif
        </h3>

        <ul class="list-group">
            @foreach($question->choices as $choice)
                <li class="list-group-item">
                    @if($choice->isCorrect())
                        <i class="bi bi-check"></i>
                        <span class="badge badge-success float-right">
                                {{ __('question/messages.choice_score', ['points' => $choice->score]) }}
                            </span>
                    @else
                        <i class="bi bi-x"></i>
                        <span class="badge badge-danger float-right">
                                {{ __('question/messages.choice_score', ['points' => $choice->score]) }}
                            </span>
                    @endif

                    @if($response->hasChoice($choice->id))
                            <i class="bi bi-flag"></i>
                    @endif

                    {{ $choice->text }}
                </li>
            @endforeach

            <li class="list-group-item list-group-item-secondary text-center">
                <p class="text-muted">
                    {{ __('question/messages.legend') }}
                    <i class="bi bi-check"></i> {{ __('question/messages.correct_answer') }}
                    <i class="bi bi-x"></i> {{ __('question/messages.incorrect_answer') }}
                    <i class="bi bi-flag"></i> {{ __('question/messages.your_choice') }}
                </p>
            </li>
        </ul>

        <div class="callout callout-info mt-4">
            {{ __('question/messages.obtained_points') }}:
            <strong>{{ __('question/messages.choice_score', ['points' => $response->score()]) }}</strong>
        </div>
    </div>
</div>
