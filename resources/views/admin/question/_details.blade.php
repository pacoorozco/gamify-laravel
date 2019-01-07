<div class="box box-solid {{ ($action == 'show') ? 'box-default' : 'box-danger' }}">
    <div class="box-header">
        <h3 class="box-title">{{ $question->name }}
            <span class="badge">{{ trans('admin/question/model.status_list.' . $question->status) }}</span>
            @if ($question->hidden)
                <span class="badge">hidden</span>
            @endif
        </h3>
    </div>
    <div class="box-body">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ trans('admin/question/model.question') }}
            </div>
            <div class="panel-body">
                {!! $question->question !!}
            </div>
        </div>

        <!-- choices -->
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ trans('admin/question/title.answer_section') }}
            </div><!-- ./ panel-header -->
            <div class="panel-body">
                @if (count($question->choices) > 0)
                    {!! Form::label('type', trans('admin/question/model.type'), ['class' => 'control-label']) !!}
                    {{ trans('admin/question/model.type_list.' . $question->type) }}
                    <table class="table table-hover">
                        <tr>
                            <th>{{ trans('admin/question/model.choice_text') }}</th>
                            <th>{{ trans('admin/question/model.choice_score') }}</th>
                            <th>{{ trans('admin/question/model.choice_correct') }}</th>
                        </tr>
                        @foreach ($question->choices as $choice)
                            <tr>
                                <td>{{ $choice->text }}</td>
                                <td>{{ $choice->score }}</td>
                                <td>{{ $choice->correct ? trans('general.yes') : trans('general.no') }}</td>
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
                {{ trans('admin/question/model.solution') }}
            </div>
            <div class="panel-body">
                {!! $question->solution !!}
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                {{ trans('admin/question/title.tags_section') }}
            </div>
            <div class="panel-body">
                @forelse($question->tagArray as $tag)
                    <span class="label label-info">{{ $tag }}</span>
                @empty
                    {{ trans('admin/question/model.tags_none') }}
                @endforelse
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                {{ trans('admin/question/title.other_section') }}
            </div>
            <div class="panel-body">
                <p>{{ trans('admin/question/model.created_by', ['who' => $question->created_by, 'when' => $question->created_at->toDayDateTimeString()]) }}</p>
                <p>{{ trans('admin/question/model.updated_by', ['who' => $question->updated_by, 'when' => $question->updated_at->toDayDateTimeString()]) }}</p>
            </div>
        </div>

    </div>
    <div class="box-footer">
        <a href="{{ route('admin.questions.index') }}">
            <button type="button" class="btn btn-primary">
                <i class="fa fa-arrow-left"></i> {{ trans('general.back') }}
            </button>
        </a>
        @if ($action == 'show')
            <a href="{{ route('admin.questions.edit', $question) }}">
                <button type="button" class="btn btn-primary">
                    <i class="fa fa-pencil"></i> {{ trans('general.edit') }}
                </button>
            </a>
        @else
            {!! Form::button('<i class="fa fa-trash-o"></i>' . trans('general.delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
        @endif
    </div>
</div>
