<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="bi bi-question-octagon-fill"></i>
            Recently published questions
        </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="bi bi-caret-up-fill"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>{{ __('admin/question/model.name') }}</th>
                <th>{{ __('admin/question/model.hidden') }}</th>
                <th>{{ __('admin/question/model.publication_date') }}</th>
                <th>{{ __('general.edit') }}</th>
            </tr>
            </thead>
            @forelse($latest_questions as $question)
                <tr>
                    <td>
                        {{ $question->name }}
                        {{ $question->present()->publicUrlLink }}
                    </td>
                    <td>
                        {{ $question->present()->visibilityBadge() }}
                    </td>
                    <td>{{ $question->present()->publicationDate }}</td>
                    <td>
                        <a href="{{ route('admin.questions.edit', $question) }}">
                            <button type="button" class="btn btn-xs btn-primary" title="{{ __('general.edit') }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                        </a>
                    </td>
                </tr>
            @empty
                <tr class="warning">
                    <td colspan="5" class="text-center">{{ __('admin/question/messages.no_published_questions') }}</td>
                </tr>
            @endforelse
        </table>
    </div>
</div>
