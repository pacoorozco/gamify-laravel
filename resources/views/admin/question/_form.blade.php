{{-- Create / Edit Question Form --}}

@section('meta')

@endsection

@if (isset($question))
    {!! Form::model($question, [
                'route' => ['admin.questions.update', $question],
                'method' => 'put',
                'files' => true
                ]) !!}
@else
    {!! Form::open([
                'route' => ['admin.questions.store'],
                'method' => 'post',
                'files' => true
                ]) !!}
@endif

<div class="row">
    <div class="col-xs-8">

        <!-- general section -->
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('admin/question/title.general_section')</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <!-- name -->
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    {!! Form::label('name', __('admin/question/model.name'), ['class' => 'control-label required']) !!}
                    <div class="controls">
                        {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        <span class="text-muted"><i
                                class="fa fa-info-circle"></i> @lang('admin/question/model.name_help')</span>
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
                <!-- ./ name -->

                <!-- question -->
                <div class="form-group {{ $errors->has('question') ? 'has-error' : '' }}">
                    {!! Form::label('question', __('admin/question/model.question'), ['class' => 'control-label required']) !!}
                    <div class="controls">
                        {!! Form::textarea('question', null, ['class' => 'form-control editor']) !!}
                        <span class="text-muted"><i
                                class="fa fa-info-circle"></i> @lang('admin/question/model.question_help')</span>
                        <span class="help-block">{{ $errors->first('question', ':message') }}</span>
                    </div>
                </div>
                <!-- ./ question -->

                <!-- type -->
                <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                    {!! Form::label('type', __('admin/question/model.type'), ['class' => 'control-label required']) !!}
                    <div class="controls">
                        {!! Form::select('type', __('admin/question/model.type_list'), null, ['class' => 'form-control']) !!}
                        {{ $errors->first('type', '<span class="help-inline">:message</span>') }}
                    </div>
                </div>
                <!-- ./ type -->

                <!-- answers -->
            @include('admin/question/_form_choices')
            <!-- ./ answers -->

                <!-- solution -->
                <div class="form-group {{ $errors->has('solution') ? 'has-error' : '' }}">
                    {!! Form::label('solution', __('admin/question/model.solution'), ['class' => 'control-label']) !!}
                    <div class="controls">
                        {!! Form::textarea('solution', null, ['class' => 'form-control editor']) !!}
                        <span class="text-muted"><i
                                class="fa fa-info-circle"></i> @lang('admin/question/model.solution_help')</span>
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
                <h3 class="box-title">@lang('admin/question/title.publish_section')</h3>
            </div>
            <div class="box-body">
                <!-- status -->
                @if (isset($question))
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        {!! Form::label('status', __('admin/question/model.status'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::select('status', __('admin/question/model.status_list'), null, ['class' => 'form-control']) !!}
                            {{ $errors->first('status', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>
            @else
                {!! Form::hidden('status','draft') !!}
            @endif
            <!-- ./ status -->
                <!-- hidden -->
                <div class="form-group {{ $errors->has('hidden') ? 'has-error' : '' }}">
                    {!! Form::label('hidden', __('admin/question/model.hidden'), ['class' => 'control-label required']) !!}
                    <div class="controls">
                        {!! Form::select('hidden', ['0' => __('admin/question/model.hidden_no'), '1' => trans('admin/question/model.hidden_yes')], null, ['class' => 'form-control']) !!}
                        <span class="text-muted"><i
                                class="fa fa-info-circle"></i> @lang('admin/question/model.hidden_help')
                            </span>
                        {{ $errors->first('hidden', '<span class="help-inline">:message</span>') }}
                    </div>
                </div>
                <!-- ./ hidden -->
            </div>
            <div class="box-footer">
                <!-- form actions -->
                <a href="{{ route('admin.questions.index') }}" class="btn btn-primary">
                    <i class="fa fa-arrow-left"></i> @lang('general.back')
                </a>
            {!! Form::button(__('button.save'), ['type' => 'submit', 'class' => 'btn btn-success']) !!}
            <!-- ./ form actions -->
            </div>

        </div>
        <!-- ./ publish section -->
        <!-- badges section -->
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('admin/question/title.badges_section')</h3>
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
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('admin/question/title.tags_section')</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('tag_list', __('admin/question/model.tags'), ['class' => 'control-label']) !!}
                    <div class="controls">
                        {!! Form::select('tag_list[]', $availableTags, $selectedTags, ['class' => 'form-control', 'multiple' => 'multiple', 'id' => 'tag_list']) !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- ./ tags section -->

    @if (isset($question))
        <!-- other information section -->
            <div class="box box-solid collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin/question/title.other_section')</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <p>{{ __('admin/question/model.created_by', ['who' => $question->created_by, 'when' => $question->created_at->toDayDateTimeString()]) }}</p>
                    <p>{{ __('admin/question/model.updated_by', ['who' => $question->updated_by, 'when' => $question->updated_at->toDayDateTimeString()]) }}</p>
                </div>
            </div>
            <!-- ./ other information section -->
        @endif
    </div>
</div>

{!! Form::close() !!}

{{-- Styles --}}
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/AdminLTE/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('vendor/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
@endpush

{{-- Scripts --}}
@push('scripts')
    <script src="{{ asset('vendor/AdminLTE/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('vendor/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>

    <script>
        $(function () {
            $("#tag_list").select2({
                tags: true,
                placeholder: '@lang('admin/question/model.tags_help')',
                tokenSeparators: [',', ' '],
                allowClear: true,
                width: '100%'
            });

            $('.editor').wysihtml5({
                toolbar: {
                    "font-styles": false,
                },
            })
        });
    </script>
@endpush
