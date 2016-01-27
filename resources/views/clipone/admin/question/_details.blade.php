<div class="row">
    <div class="col-xs-12">

        {{-- <img src="{{ $question->image->url('small') }}" width="64" class="img-thumbnail"/> --}}
        <h2>{{ $question->name }}
            <span class="badge">{{ $question->status }}</span>
            @if ($question->hidden)
                <span class="badge">hidden</span>
            @endif
        </h2>


        {{ $question->question }}

        <p>
            {!! Form::label('type', trans('admin/question/model.type'), array('class' => 'control-label')) !!}
            {{ $question->type }}
        </p>

        <!-- choices -->
        <p>{!! Form::label('choices', trans('admin/question/model.choices'), array('class' => 'control-label')) !!}</p>
        <ul>
            @if(empty($question->choices))
                <li>There isn't any choice available</li>
            @else
                @foreach ($question->choices as $option)
                    <li>{{ $option->text }}</li>
                @endforeach
            @endif
        </ul>
        <!-- ./ choices -->

        {{ $question->solution }}

    </div>
</div>

</div>
<div class="row">
    <div class="col-xs-12">

        <div class="form-group">
            <div class="controls">
                <a href="{{ route('admin.questions.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{ trans('general.back') }}</a>
                @if ($action == 'show')
                    <a href="{{ route('admin.questions.edit', $question->id) }}"
                       class="btn btn-primary">{{ trans('button.edit') }}</a>
                @else
                    {!! Form::button('<i class="fa fa-trash-o"></i>' . trans('general.delete'), array('type' => 'submit', 'class' => 'btn btn-danger')) !!}
                @endif
            </div>
        </div>

    </div>
</div>
