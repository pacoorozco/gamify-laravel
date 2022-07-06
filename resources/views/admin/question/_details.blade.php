<div class="box {{ ($action == 'show') ? 'box-info' : 'box-danger' }}">
    <div class="box-header with-border">
        <h3 class="box-title">
            {{ $question->present()->name }}
        </h3>
        {{ $question->present()->publicUrlLink }}
        {{ $question->present()->visibilityBadge }}
        {{ $question->present()->statusBadge }}

    </div>
    <div class="box-body">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('admin/question/model.question') }}
            </div>
            <div class="panel-body">
                {{ $question->present()->statement }}
            </div>
        </div>

        <!-- choices -->
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('admin/question/title.answer_section') }}
            </div><!-- ./ panel-header -->
            <div class="panel-body">
                @if (count($question->choices) > 0)
                    {!! Form::label('type', __('admin/question/model.type'), ['class' => 'control-label']) !!}
                    {{ __('admin/question/model.type_list.' . $question->type) }}
                    <table class="table table-hover">
                        <tr>
                            <th>{{ __('admin/question/model.choice_text') }}</th>
                            <th>{{ __('admin/question/model.choice_score') }}</th>
                            <th>{{ __('admin/question/model.choice_correctness') }}</th>
                        </tr>
                        @foreach ($question->choices as $choice)
                            <tr>
                                <td>{{ $choice->text }}</td>
                                <td>{{ $choice->score }}</td>
                                <td>{{ $choice->isCorrect() ? __('general.yes') : __('general.no') }}
                            </tr>
                        @endforeach
                    </table>
                @else
                    No choices
                @endif
            </div>
        </div>
        <!-- ./ choices -->

        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('admin/question/model.solution') }}
            </div>
            <div class="panel-body">
                {{ $question->present()->explanation }}
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('admin/question/title.tags_section') }}
            </div>
            <div class="panel-body">
                @forelse($question->tagArray as $tag)
                    <span class="label label-info">{{ $tag }}</span>
                @empty
                    {{ __('admin/question/model.tags_none') }}
                @endforelse
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('admin/question/title.other_section') }}
            </div>
            <div class="panel-body">
                <p>{{ __('admin/question/model.created_by', ['who' => $question->creator->name, 'when' => $question->created_at->toDayDateTimeString()]) }}</p>
                <p>{{ __('admin/question/model.updated_by', ['who' => $question->updater->name, 'when' => $question->updated_at->toDayDateTimeString()]) }}</p>
            </div>
        </div>

    </div>
    <div class="box-footer">
        <a href="{{ route('admin.questions.index') }}">
            <button type="button" class="btn btn-primary">
                <i class="fa fa-arrow-left"></i> {{ __('general.back') }}
            </button>
        </a>
        @if ($action == 'show')
            <a href="{{ route('admin.questions.edit', $question) }}">
                <button type="button" class="btn btn-primary">
                    <i class="fa fa-pencil"></i> {{ __('general.edit') }}
                </button>
            </a>
        @else
            {!! Form::button('<i class="fa fa-trash-o"></i>' . __('general.delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
        @endif
    </div>
</div>
