@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/question/title.create_a_new_question'))

{{-- Content Header --}}
@section('header')
    @lang('admin/question/title.create_a_new_question')
    <small>create a new question</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> @lang('admin/site.dashboard')
        </a>
    </li>
    <li>
        <a href="{{ route('admin.questions.index') }}">
            @lang('admin/site.questions')
        </a>
    </li>
    <li class="active">
        @lang('admin/question/title.create_a_new_question')
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    {!! Form::open([
                'route' => ['admin.questions.store'],
                'method' => 'post',
                'files' => true
                ]) !!}

    <div class="row">
        <div class="col-xs-8">

            <!-- general section -->
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin/question/title.general_section')</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <!-- name -->
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name', __('admin/question/model.name'), ['class' => 'control-label required']) !!}
                        <p class="text-muted">@lang('admin/question/model.name_help')</p>
                        <div class="controls">
                            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                    <!-- ./ name -->

                    <!-- question -->
                    <div class="form-group {{ $errors->has('question') ? 'has-error' : '' }}">
                        {!! Form::label('question', __('admin/question/model.question'), ['class' => 'control-label required']) !!}
                        <p class="text-muted">@lang('admin/question/model.question_help')</p>
                        <div class="controls">
                            {!! Form::textarea('question', null, ['class' => 'form-control editor', 'style' => 'width:100%']) !!}
                            <span class="help-block">{{ $errors->first('question', ':message') }}</span>
                        </div>
                    </div>
                    <!-- ./ question -->

                    <!-- type -->
                    <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                        {!! Form::label('type', __('admin/question/model.type'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::select('type', __('admin/question/model.type_list'), null, ['class' => 'form-control']) !!}
                            <span class="help-block">{{ $errors->first('type', ':message') }}</span>
                        </div>
                    </div>
                    <!-- ./ type -->

                    <!-- answers -->
                @include('admin/question/_form_choices')
                <!-- ./ answers -->

                    <!-- solution -->
                    <div class="form-group {{ $errors->has('solution') ? 'has-error' : '' }}">
                        {!! Form::label('solution', __('admin/question/model.solution'), ['class' => 'control-label']) !!}
                        <p class="text-muted">@lang('admin/question/model.solution_help')</p>
                        <div class="controls">
                            {!! Form::textarea('solution', null, ['class' => 'form-control editor', 'style' => 'width:100%']) !!}

                            <span class="help-block">{{ $errors->first('solution', ':message') }}</span>
                        </div>
                    </div>
                    <!-- ./ solution -->
                </div>
            </div>
            <!-- ./ general section -->

        </div>
        <div class="col-xs-4">

            <!-- publish widget -->
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin/question/title.publish_section')</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <!-- status -->
                    <div class="form-group">
                        {!! Form::label('status', __('admin/question/model.status'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::hidden('status','draft') !!}
                            @lang('admin/question/model.status_list.draft')
                        </div>
                    </div>
                    <!-- ./ status -->

                    <!-- visibility -->
                    <div class="form-group {{ $errors->has('hidden') ? 'has-error' : '' }}">
                        {!! Form::label('hidden', __('admin/question/model.hidden'), ['class' => 'control-label required']) !!}
                        <div id="visibilityStatus">
                            <span>@lang('admin/question/model.visibility_options.' . (old('hidden') ?: 0))</span>
                            <a href="#" id="enableVisibilityControl">@lang('general.edit')</a>
                        </div>
                        <div class="controls hidden" id="visibilityControls">
                            <div class="radio">
                                <label class="control-label">
                                    {{ Form::radio('hidden', '0', true, [ 'id' => 'visibilityPublic']) }}
                                    @lang('admin/question/model.visibility_options.0')
                                </label>
                            </div>
                            <div class="radio">
                                <label class="control-label">
                                    {{ Form::radio('hidden', '1', false, [ 'id' => 'visibilityPrivate']) }}
                                    @lang('admin/question/model.visibility_options.1')
                                </label>
                                <p class="text-muted">@lang('admin/question/model.hidden_help')</p>
                            </div>
                        </div>
                        <span class="help-block">{{ $errors->first('hidden', ':message') }}</span>
                    </div>
                    <!-- ./ visibility -->

                    <!-- publication date -->
                    <div class="form-group {{ $errors->has('publication_date') ? 'has-error' : '' }}">
                        {!! Form::label('publication_date', __('admin/question/model.publication_date'), ['class' => 'control-label']) !!}
                        <div id="publicationDateStatus">
                            @if (empty(old('publication_date')))
                                <span>@lang('admin/question/model.publication_date_now')</span>
                            @else
                                <span>@lang('admin/question/model.publication_date_on') {{ old('publication_date') }}</span>
                            @endif
                            <a href="#" id="enablePublicationDateControl">@lang('general.edit')</a>
                        </div>
                        <div class="controls hidden" id="publicationDateControls">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                {!! Form::text('publication_date', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => __('admin/question/model.publication_date_placeholder')]) !!}
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-flat" id="resetPublicationDate"><i
                                            class="fa fa-times"></i></button>
                                </span>
                            </div>
                        </div>
                        <span class="help-block">{{ $errors->first('publication_date', ':message') }}</span>
                    </div>
                    <!-- ./ publication date -->
                </div>
                <div class="box-footer">
                    <a href="{{ route('admin.questions.index') }}" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> @lang('general.back')
                    </a>
                {!! Form::button(__('admin/question/model.save_button'), ['type' => 'submit', 'class' => 'btn btn-primary', 'id' => 'save']) !!}
                @if (empty(old('publication_date')))
                    {!! Form::button(__('admin/question/model.publish_button'), ['type' => 'submit', 'class' => 'btn btn-success pull-right', 'id' => 'publish']) !!}
                @else
                    {!! Form::button(__('admin/question/model.schedule_button'), ['type' => 'submit', 'class' => 'btn btn-success pull-right', 'id' => 'publish']) !!}
                @endif
                <!-- ./ form actions -->
                </div>

            </div>
            <!-- ./ publish widget -->

            <!-- badges section -->
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin/question/title.badges_section')</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="callout callout-info">
                        <h4>NOTE!</h4>

                        <p>After saving this question you will be able to add some actions.</p>
                    </div>
                </div>
            </div>
            <!-- ./ badges section -->
            <!-- tags section -->
            <div class="box box-solid collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin/question/title.tags_section')</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('tags', __('admin/question/model.tags'), ['class' => 'control-label']) !!}
                        <div class="controls">
                            {!! Form::select('tags[]', $availableTags, null, ['class' => 'form-control', 'multiple' => 'multiple', 'id' => 'tags']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./ tags section -->

        </div>
    </div>

    {!! Form::close() !!}
@endsection

{{-- Styles --}}
@push('styles')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/AdminLTE/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('vendor/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('vendor/jquery-datetimepicker/jquery.datetimepicker.min.css') }}">
@endpush

{{-- Scripts --}}
@push('scripts')
    <script
        src="{{ asset('vendor/AdminLTE/plugins/select2/js/select2.full.min.js') }}"></script>
    <script
        src="{{ asset('vendor/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script
        src="{{ asset('vendor/jquery-datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>

    <script>
        $(function () {
            $("#tags").select2({
                tags: true,
                placeholder: "@lang('admin/question/model.tags_help')",
                tokenSeparators: [',', ' '],
                allowClear: true,
                width: "100%"
            });

            $('.editor').wysihtml5({
                toolbar: {
                    "font-styles": false,
                },
            });

            $("#enableVisibilityControl").click(function () {
                $("#visibilityStatus").addClass("hidden");
                $("#visibilityControls").removeClass("hidden");
            });

            $.datetimepicker.setLocale("@lang('site.dateTimePickerLang')");
            $("#publication_date").datetimepicker({
                minDate: 0,
                minTime: 0,
                closeOnDateSelect: true,
            });

            $("#enablePublicationDateControl").click(function () {
                $("#publicationDateStatus").addClass("hidden");
                $("#publicationDateControls").removeClass("hidden");
                $("#publication_date").datetimepicker("show");
            });

            $("#publication_date").change(function () {
                if ($("#publication_date").val() === "") {
                    $("#publish").text("@lang('admin/question/model.publish_button')");
                } else {
                    $("#publish").text("@lang('admin/question/model.schedule_button')");
                }
            });

            $("#resetPublicationDate").click(function () {
                $("#publication_date").val("");
                $("#publication_date").change();
            });
        });
    </script>
@endpush
