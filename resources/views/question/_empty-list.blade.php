<p class="text-center">
    @if (Auth::user()->hasQuestionsToAnswer())
        @lang('question/messages.ony_hidden_questions_pending')
    @else
        @lang('question/messages.no_pending_questions')
    @endif
</p>

