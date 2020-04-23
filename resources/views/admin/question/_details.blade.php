<div class="box {{ ($action == 'show') ? 'box-info' : 'box-danger' }}">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $question->name }}
            @include('admin/question/partials._add_status_label', ['status' => $question->status])
            @include('admin/question/partials._add_visibility_label', ['hidden' => $question->hidden])
        </h3>
    </div>
    <div class="box-body">
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('admin/question/model.question')
            </div>
            <div class="panel-body">
                {!! $question->question !!}
            </div>
        </div>

        <!-- choices -->
        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('admin/question/title.answer_section')
            </div><!-- ./ panel-header -->
            <div class="panel-body">
                @if (count($question->choices) > 0)
                    {!! Form::label('type', __('admin/question/model.type'), ['class' => 'control-label']) !!}
                    {{ __('admin/question/model.type_list.' . $question->type) }}
                    <table class="table table-hover">
                        <tr>
                            <th>@lang('admin/question/model.choice_text')</th>
                            <th>@lang('admin/question/model.choice_score')</th>
                            <th>@lang('admin/question/model.choice_correct')</th>
                        </tr>
                        @foreach ($question->choices as $choice)
                            <tr>
                                <td>{{ $choice->text }}</td>
                                <td>{{ $choice->score }}</td>
                                <td>{{ $choice->correct ? __('general.yes') : trans('general.no') }}</td>
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
                @lang('admin/question/model.solution')
            </div>
            <div class="panel-body">
                {!! $question->solution !!}
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('admin/question/title.tags_section')
            </div>
            <div class="panel-body">
                @forelse($question->tagArray as $tag)
                    <span class="label label-info">{{ $tag }}</span>
                @empty
                    @lang('admin/question/model.tags_none')
                @endforelse
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                @lang('admin/question/title.other_section')
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
                <i class="fa fa-arrow-left"></i> @lang('general.back')
            </button>
        </a>
        @if ($action == 'show')
            <a href="{{ route('admin.questions.edit', $question) }}">
                <button type="button" class="btn btn-primary">
                    <i class="fa fa-pencil"></i> @lang('general.edit')
                </button>
            </a>
        @else
            {!! Form::button('<i class="fa fa-trash-o"></i>' . __('general.delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
        @endif
    </div>
</div>
