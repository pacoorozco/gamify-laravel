<div class="box box-solid box-default">
    <div class="box-header">
        <h3 class="box-title">{{ $question->name }}
            <span class="badge">{{ $question->status }}</span>
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
                {{ trans('admin/choice/title.current_choices') }}
            </div><!-- ./ panel-header -->
            <div class="panel-body">
                @if (count($question->choices) > 0)
                    {!! Form::label('type', trans('admin/question/model.type'), array('class' => 'control-label')) !!}
                    {{ $question->type }}
                    <table class="table table-hover">
                        <tr>
                            <th>{{ trans('admin/choice/table.text') }}</th>
                            <th>{{ trans('admin/choice/table.points') }}</th>
                            <th>{{ trans('admin/choice/table.correct') }}</th>
                        </tr>
                        @foreach ($question->choices as $choice)
                            <tr>
                                <td>{{ $choice->text }}</td>
                                <td>{{ $choice->points }}</td>
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

                {{ trans('admin/question/model.tags') }}
            </div>
            <div class="panel-body">
                <ul>
                    @foreach($question->tagList as $tag)
                        <li>{{ $tag }}</li>
                    @endforeach
                </ul>
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
            {!! Form::button('<i class="fa fa-trash-o"></i>' . trans('general.delete'), array('type' => 'submit', 'class' => 'btn btn-danger')) !!}
        @endif
    </div>
</div>
