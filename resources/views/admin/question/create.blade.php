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
                'id' => 'formCreateQuestion',
                'route' => ['admin.questions.store'],
                'method' => 'post',
                ]) !!}

    <div class="row">
        <div class="col-xs-8">

            <!-- general section -->
            <div class="box box-solid">
                <div class="box-body">

                    <fieldset>
                        <legend>
                            @lang('admin/question/title.general_section')
                        </legend>

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

                        <!-- question text -->
                        <div class="form-group {{ $errors->has('question') ? 'has-error' : '' }}">
                            {!! Form::label('question', __('admin/question/model.question'), ['class' => 'control-label required']) !!}
                            <p class="text-muted">@lang('admin/question/model.question_help')</p>
                            <div class="controls">
                                {!! Form::textarea('question', null, ['class' => 'form-control editor', 'style' => 'width:100%']) !!}
                                <span class="help-block">{{ $errors->first('question', ':message') }}</span>
                            </div>
                        </div>
                        <!-- ./ question text -->

                        <!-- type -->
                        <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                            {!! Form::label('type', __('admin/question/model.type'), ['class' => 'control-label required']) !!}
                            <div class="controls">
                                {!! Form::select('type', __('admin/question/model.type_list'), null, ['class' => 'form-control']) !!}
                                <span class="help-block">{{ $errors->first('type', ':message') }}</span>
                            </div>
                        </div>
                        <!-- ./ type -->
                    </fieldset>

                    <!-- options -->
                @include('admin/question/_form_choices')
                <!-- ./ options -->

                    <fieldset>
                        <legend>
                            @lang('admin/question/title.optional_section')
                        </legend>

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

                        <!-- tags -->
                        <div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}">
                            {!! Form::label('tags', __('admin/question/model.tags'), ['class' => 'control-label']) !!}
                            <div class="controls">
                                {!! Form::select('tags[]', $availableTags, null, ['class' => 'form-control', 'multiple' => 'multiple', 'id' => 'tags']) !!}
                            </div>
                        </div>
                        <!-- ./ tags -->

                    </fieldset>
                </div>
            </div>
            <!-- ./ general section -->

        </div>
        <div class="col-xs-4">

            <!-- badges section -->
            <div class="box box-solid collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin/question/title.badges_section')</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">

                    <table class="table">
                        <tbody>
                        <tr>
                            <th>@lang('admin/action/table.action')</th>
                            <th>@lang('admin/action/table.when')</th>
                            <th>@lang('admin/action/table.actions')</th>
                        </tr>

                        @foreach($globalActions as $badge)
                            <tr>
                                <td>{{ $badge->name }}</td>
                                <td>{{ $badge->actuators->description }}</td>
                                <td>Global</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="callout callout-info">
                        <h4>NOTE!</h4>

                        <p>After saving this question you will be able to add some actions.</p>
                    </div>
                </div>
            </div>
            <!-- ./ badges section -->

            <!-- publish section -->
            <div class="box box-solid">
                <div class="box-body">

                    <fieldset>
                        <legend>
                            @lang('admin/question/title.publish_section')
                        </legend>

                        <!-- save draft and preview -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="submitDraftBtn">
                                @lang('button.save_as_draft')
                            </button>
                        </div>
                        <!-- ./ save draft and preview -->

                        <!-- status -->
                        <div class="form-group">
                            {!! Form::label('status', __('admin/question/model.status'), ['class' => 'control-label required']) !!}
                            <div class="controls">
                                <span class="form-control-static">@lang('admin/question/model.status_list.draft')</span>
                                {!! Form::hidden('status','draft') !!}
                            </div>
                        </div>
                        <!-- ./ status -->

                        <!-- visibility -->
                        <div class="form-group {{ $errors->has('hidden') ? 'has-error' : '' }}">
                            {!! Form::label('hidden', __('admin/question/model.hidden'), ['class' => 'control-label required']) !!}
                            <a href="#" id="enableVisibilityControls">@lang('general.edit')</a>
                            <div id="visibilityStatus">
                            <span class="form-control-static">
                                {{ old('hidden') === '1' ? __('admin/question/model.hidden_yes') : __('admin/question/model.hidden_no') }}
                            </span>
                            </div>
                            <div class="controls hidden" id="visibilityControls">
                                <div class="radio">
                                    <label class="control-label">
                                        {{ Form::radio('hidden', '0', true, [ 'id' => 'visibilityPublic']) }}
                                        @lang('admin/question/model.hidden_no')
                                    </label>
                                </div>
                                <div class="radio">
                                    <label class="control-label">
                                        {{ Form::radio('hidden', '1', false, [ 'id' => 'visibilityPrivate', 'aria-describedby' => 'helpHiddenYes']) }}
                                        @lang('admin/question/model.hidden_yes')
                                    </label>
                                    <span id="helpHiddenYes"
                                          class="text-muted">@lang('admin/question/model.hidden_yes_help')</span>
                                </div>
                            </div>
                            <span class="help-block">{{ $errors->first('hidden', ':message') }}</span>
                        </div>
                        <!-- ./ visibility -->

                        <!-- publication date -->
                        <div class="form-group {{ $errors->has('publication_date') ? 'has-error' : '' }}">
                            {!! Form::label('publication_date', __('admin/question/model.publication_date'), ['class' => 'control-label']) !!}
                            <a href="#" id="enablePublicationDateControls">@lang('general.edit')</a>
                            <div id="publicationDateStatus">
                            <span class="form-control-static">
                            @if (empty(old('publication_date')))
                                    @lang('admin/question/model.publish_immediately')
                                @else
                                    @lang('admin/question/model.publish_on', ['datetime' => old('publication_date')])
                                @endif
                            </span>
                            </div>
                            <div class="controls hidden" id="publicationDateControls">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    {!! Form::text('publication_date', null, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => __('admin/question/model.publication_date_placeholder')]) !!}
                                    <span class="input-group-btn">
                                    <button type="button" class="btn btn-flat" id="resetPublicationDateBtn">
                                        @lang('admin/question/model.publish_immediately')
                                    </button>
                                </span>
                                </div>
                            </div>
                            <span class="help-block">{{ $errors->first('publication_date', ':message') }}</span>
                        </div>
                        <!-- ./ publication date -->
                    </fieldset>

                </div>
                <div class="box-footer">
                    <a href="{{ route('admin.questions.index') }}" class="btn btn-default">
                        @lang('button.back')
                    </a>
                    <button type="submit" class="btn btn-success pull-right" id="submitPublishBtn">
                        @lang('button.publish')
                    </button>
                </div>

            </div>
            <!-- ./ publish section -->

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

            $("#submitDraftBtn").click(function () {
                $("#status").val("draft");
                $("#formCreateQuestion").submit();
            });

            $("#submitPublishBtn").click(function () {
                $("#status").val("publish");
                $("#formCreateQuestion").submit();
            });

            $("#enableVisibilityControls").click(function () {
                $("#visibilityStatus").addClass("hidden");
                $("#visibilityControls").removeClass("hidden");
                $("#enableVisibilityControls").addClass("hidden");
            });

            $.datetimepicker.setLocale("@lang('site.dateTimePickerLang')");
            $("#publication_date").datetimepicker({
                minDate: 0,
                format: "Y-m-d H:i",
                defaultTime: '09:00',
            });

            $("#enablePublicationDateControls").click(function () {
                $("#publicationDateStatus").addClass("hidden");
                $("#publicationDateControls").removeClass("hidden");
                $("#enablePublicationDateControls").addClass("hidden");
                $("#publication_date").datetimepicker("show");
            });

            $("#resetPublicationDateBtn").click(function () {
                $("#publication_date").val("");
                $("#publication_date").change();
            });
        });
    </script>
@endpush
