<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $question->name }}</h3>
    </div>
    <div class="box-body">
        <div id="question_statement">
            {{ $question->present()->statement }}
        </div>

        @if($question->solution)
            <div id="question_explanation" class="bg-success">
                <h4>{{ __('question/messages.explained_answer') }}</h4>
                {{ $question->present()->explanation }}
            </div>
        @endif

        <h4>
            @if($question->type == 'single')
                {{ __('question/messages.single_choice') }}
            @else
                {{ __('question/messages.multiple_choices') }}
            @endif
        </h4>

        <ul class="list-group">
            @foreach($question->choices as $choice)
                <li class="list-group-item">
                    @if($choice->isCorrect())
                        <span class="glyphicon glyphicon-ok"></span>
                        <span class="label label-success pull-right">
                                {{ __('question/messages.choice_score', ['points' => $choice->score]) }}
                            </span>
                    @else
                        <span class="glyphicon glyphicon-remove"></span>
                        <span class="label label-danger pull-right">
                                {{ __('question/messages.choice_score', ['points' => $choice->score]) }}
                            </span>
                    @endif

                    @if($response->hasChoice($choice->id))
                        <span class="glyphicon glyphicon-flag"></span>
                    @endif

                    {{ $choice->text }}
                </li>
            @endforeach

            <li class="list-group-item bg-gray text-center">
                <p class="text-muted">
                    {{ __('question/messages.legend') }}
                    <span class="glyphicon glyphicon-ok"></span> {{ __('question/messages.correct_answer') }}
                    <span class="glyphicon glyphicon-remove"></span> {{ __('question/messages.incorrect_answer') }}
                    <span class="glyphicon glyphicon-flag"></span> {{ __('question/messages.your_choice') }}
                </p>
            </li>
        </ul>

        <div class="callout callout-info">
            {{ __('question/messages.obtained_points') }}:
            <strong>{{ __('question/messages.choice_score', ['points' => $response->score()]) }}</strong>
        </div>
    </div>
</div>
