{{-- Create / Edit Question Form --}}

@section('meta')
        <!-- Unobtrusive JavaScript -->
<meta name="csrf-token" content="{!! csrf_token() !!}">
<meta name="csrf-param" content="_token">
@endsection

@if (isset($question))
    {!! Form::model($question, array(
                'route' => array('admin.questions.update', $question),
                'method' => 'put',
                'files' => true
                )) !!}
@else
    {!! Form::open(array(
                'route' => array('admin.questions.store'),
                'method' => 'post',
                'files' => true
                )) !!}
@endif

<div class="row">
    <div class="col-xs-8">

        <!-- general section -->
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('admin/question/title.general_section') }}</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <!-- name -->
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    {!! Form::label('name', trans('admin/question/model.name'), array('class' => 'control-label required')) !!}
                    <div class="controls">
                        {!! Form::text('name', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        <span class="text-muted"><i
                                    class="fa fa-info-circle"></i> {{ trans('admin/question/model.name_help') }}</span>
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
                <!-- ./ name -->

                <!-- question -->
                <div class="form-group {{ $errors->has('question') ? 'has-error' : '' }}">
                    {!! Form::label('question', trans('admin/question/model.question'), array('class' => 'control-label required')) !!}
                    <div class="controls">
                        {!! Form::textarea('question', null, array('class' => 'form-control tinymce', 'required' => 'required')) !!}
                        <span class="text-muted"><i
                                    class="fa fa-info-circle"></i> {{ trans('admin/question/model.question_help') }}</span>
                        <span class="help-block">{{ $errors->first('question', ':message') }}</span>
                    </div>
                </div>
                <!-- ./ question -->

                <!-- type -->
                <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                    {!! Form::label('type', trans('admin/question/model.type'), array('class' => 'control-label required')) !!}
                    <div class="controls">
                        {!! Form::select('type', trans('admin/question/model.type_list'), null, array('class' => 'form-control')) !!}
                        {{ $errors->first('type', '<span class="help-inline">:message</span>') }}
                    </div>
                </div>
                <!-- ./ type -->

                <!-- answers -->
                @include('admin/question/_form_choices')
                        <!-- ./ answers -->

                <!-- solution -->
                <div class="form-group {{ $errors->has('solution') ? 'has-error' : '' }}">
                    {!! Form::label('solution', trans('admin/question/model.solution'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::textarea('solution', null, array('class' => 'form-control tinymce')) !!}
                        <span class="text-muted"><i
                                    class="fa fa-info-circle"></i> {{ trans('admin/question/model.solution_help') }}</span>
                        <span class="help-block">{{ $errors->first('solution', ':message') }}</span>
                    </div>
                </div>
                <!-- ./ solution -->
            </div>
        </div>
        <!-- ./ general section -->

    </div>
    <div class="col-xs-4">

        <!-- publish section -->
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('admin/question/title.publish_section') }}</h3>
            </div>
            <div class="box-body">
                <!-- status -->
                @if (isset($question))
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        {!! Form::label('status', trans('admin/question/model.status'), array('class' => 'control-label required')) !!}
                        <div class="controls">
                            {!! Form::select('status', trans('admin/question/model.status_list'), null, array('class' => 'form-control')) !!}
                            {{ $errors->first('status', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>
                    @else
                    {!! Form::hidden('status','draft') !!}
                    @endif
                            <!-- ./ status -->
                    <!-- hidden -->
                    <div class="form-group {{ $errors->has('hidden') ? 'has-error' : '' }}">
                        {!! Form::label('hidden', trans('admin/question/model.hidden'), array('class' => 'control-label required')) !!}
                        <div class="controls">
                            {!! Form::select('hidden', array('0' => trans('admin/question/model.hidden_no'), '1' => trans('admin/question/model.hidden_yes')), null, array('class' => 'form-control')) !!}
                            <span class="text-muted"><i
                                        class="fa fa-info-circle"></i> {{ trans('admin/question/model.hidden_help') }}
                            </span>
                            {{ $errors->first('hidden', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>
                    <!-- ./ hidden -->
            </div>
            <div class="box-footer">
                <!-- form actions -->
                <a href="{{ route('admin.questions.index') }}">
                    <button type="button" class="btn btn-primary">
                        <i class="fa fa-arrow-left"></i> {{ trans('general.back') }}
                    </button>
                </a>
                {!! Form::button(trans('button.save'), array('type' => 'submit', 'class' => 'btn btn-success')) !!}
                        <!-- ./ form actions -->
            </div>

        </div>
        <!-- ./ publish section -->
        <!-- badges section -->
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('admin/question/title.badges_section') }}</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                @if (isset($question))
                    @include('admin/question/_form_actions')
                @else
                    <div class="callout callout-info">
                        <h4>NOTE!</h4>

                        <p>After saving this question you will be able to add some actions.</p>
                    </div>
                @endif
            </div>
        </div>
        <!-- ./ badges section -->
        <!-- tags section -->
        <div class="box box-solid collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('admin/question/title.tags_section') }}</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('tag_list', trans('admin/question/model.tags'), ['class' => 'control-label']) !!}
                    {!! Form::select('tag_list[]', $availableTags, null, ['class' => 'form-control tags-input', 'multiple' => 'multiple', 'id' => 'tag_list']) !!}
                </div>
            </div>
        </div>
        <!-- ./ tags section -->

        @if (isset($question))
                <!-- other information section -->
        <div class="box box-solid collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('admin/question/title.other_section') }}</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <p>{{ trans('admin/question/model.created_by', ['who' => $question->created_by, 'when' => $question->created_at->toDayDateTimeString()]) }}</p>
                <p>{{ trans('admin/question/model.updated_by', ['who' => $question->updated_by, 'when' => $question->updated_at->toDayDateTimeString()]) }}</p>
            </div>
        </div>
        <!-- ./ other information section -->
        @endif
    </div>
</div>

{!! Form::close() !!}

{{-- Styles --}}
@section('styles')
{!! HTML::style('vendor/AdminLTE/plugins/select2/select2.min.css') !!}
@endsection

{{-- Scripts --}}
@section('scripts')
{!! HTML::script('//cdn.tinymce.com/4/tinymce.min.js') !!}
{!! HTML::script('vendor/AdminLTE/plugins/select2/select2.full.min.js') !!}
        <!-- jQuery UJS -->
{!! HTML::script('vendor/jquery-ujs/src/rails.js') !!}

<script>
    $("#tag_list").select2({
        tags: true,
        placeholder: '{{ trans('admin/question/model.tags_help') }}',
        tokenSeparators: [',', ' '],
        allowClear: true
    });

    tinymce.init({
        selector: "textarea.tinymce",
        width: '100%',
        height: 270,
        statusbar: false,
        menubar: false,
        plugins: [
            "link",
            "code"
        ],
        toolbar: "bold italic underline strikethrough | removeformat | undo redo | bullist numlist | link code"
    });
</script>
@endsection