<p class="text-center">
    @if (Auth::user()->hasQuestionsToAnswer())
        {{ __('question/messages.ony_hidden_questions_pending') }}
    @else
        {{ __('question/messages.no_pending_questions') }}
    @endif
</p>

