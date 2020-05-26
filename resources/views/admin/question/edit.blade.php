@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/question/title.question_edit'))

{{-- Content Header --}}
@section('header')
    @lang('admin/question/title.question_edit')
    <small>{{ $question->name }}</small>
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
        @lang('admin/question/title.question_edit')
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    {!! Form::model($question, [
                'id' => 'formEditQuestion',
                'route' => ['admin.questions.update', $question],
                'method' => 'put',
                ]) !!}

    <div class="row">
        <div class="col-xs-8">

            <!-- general section -->
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin/question/title.general_section')</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
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

                    <!-- link -->
                    <div class="form-group">
                        <p class="text-muted">
                            <b>@lang('admin/question/model.permanent_link')</b>: {{ $question->public_url }}
                            <a href="{{ $question->public_url }}"
                               class="btn btn-default btn-xs" target="_blank">
                                @lang('general.view') <i class="fa fa-external-link"></i>
                            </a>
                        </p>
                    </div>
                    <!-- ./link -->

                    <!-- question text -->
                    <div class="form-group {{ $errors->has('question') ? 'has-error' : '' }}">
                        {!! Form::label('question', __('admin/question/model.question'), ['class' => 'control-label required']) !!}
                        <p class="text-muted">@lang('admin/question/model.question_help')</p>
                        <div class="controls">
                            {!! Form::textarea('question', null, ['class' => 'form-control editor', 'style' => 'width:100%']) !!}
                            <span class="help-block">{{ $errors->first('question', ':message') }}</span>
                        </div>
                    </div>
                    <!-- ./ question text-->

                    <!-- type -->
                    <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                        {!! Form::label('type', __('admin/question/model.type'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::select('type', __('admin/question/model.type_list'), null, ['class' => 'form-control required']) !!}
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

            <!-- publish section -->
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin/question/title.publish_section')</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">

                    <!-- save draft and preview -->
                    <div class="form-group">
                        @if ($question->isPublished())
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#saveAsDraftConfirmationModal">
                                @lang('button.save_as_draft')
                            </button>
                            <!-- modal: saveAsDraftConfirmationModal -->
                            <div class="modal fade" id="saveAsDraftConfirmationModal" tabindex="-1" role="dialog"
                                 aria-labelledby="saveAsDraftConfirmationModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title" id="saveAsDraftConfirmationModalLabel">
                                                @lang('admin/question/title.un-publish_confirmation')
                                            </h4>
                                        </div>
                                        <div class="modal-body">
                                            @lang('admin/question/messages.un-publish_confirmation_notice')
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                @lang('general.close')
                                            </button>
                                            <button type="button" class="btn btn-primary" id="submitDraftBtn">
                                                @lang('admin/question/messages.un-publish_confirmation_button')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- ./ modal: saveAsDraftConfirmationModal -->
                            </div>
                        @else
                            <button type="button" class="btn btn-primary" id="submitDraftBtn">
                                @lang('button.save_as_draft')
                            </button>
                        @endif
                    </div>
                    <!-- ./ save draft and preview -->

                    <!-- status -->
                    <div class="form-group">
                        {!! Form::label('status', __('admin/question/model.status'), ['class' => 'control-label']) !!}
                        <div class="controls">
                            <span>@lang('admin/question/model.status_list.' . $question->status)</span>
                            {!! Form::hidden('status', $question->status) !!}
                        </div>
                    </div>
                    <!-- ./ status -->

                    <!-- visibility -->
                    <div class="form-group {{ $errors->has('hidden') ? 'has-error' : '' }}">
                        {!! Form::label('hidden', __('admin/question/model.hidden'), ['class' => 'control-label required']) !!}
                        <a href="#" id="enableVisibilityControls">@lang('general.edit')</a>
                        <div id="visibilityStatus">
                            <span>
                                {{ old('hidden', $question->hidden ? '1' : '0') === '1' ? __('admin/question/model.hidden_yes') : __('admin/question/model.hidden_no') }}
                            </span>
                        </div>
                        <div class="controls hidden" id="visibilityControls">
                            <div class="radio">
                                <label class="control-label">
                                    {{ Form::radio('hidden', '0', null, [ 'id' => 'visibilityPublic']) }}
                                    @lang('admin/question/model.hidden_no')
                                </label>
                            </div>
                            <div class="radio">
                                <label class="control-label">
                                    {{ Form::radio('hidden', '1', null, [ 'id' => 'visibilityPrivate']) }}
                                    @lang('admin/question/model.hidden_yes')
                                    <p class="text-muted">@lang('admin/question/model.hidden_yes_help')</p>
                                </label>
                            </div>
                        </div>
                        <span class="help-block">{{ $errors->first('hidden', ':message') }}</span>
                    </div>
                    <!-- ./ visibility -->

                    <!-- publication date -->
                    <div class="form-group {{ $errors->has('publication_date') ? 'has-error' : '' }}">
                        {!! Form::label('publication_date', __('admin/question/model.publication_date'), ['class' => 'control-label']) !!}
                        @unless($question->isPublished())
                            <a href="#" id="enablePublicationDateControls">@lang('general.edit')</a>
                        @endunless
                        <div id="publicationDateStatus">
                            <span>
                            @switch($question->status)
                                    @case(\Gamify\Question::DRAFT_STATUS)
                                    @if (empty(old('publication_date')))
                                        @lang('admin/question/model.publish_immediately')
                                    @else
                                        @lang('admin/question/model.publish_on', ['datetime' => old('publication_date', $question->publication_date)])
                                    @endif
                                    @break
                                    @case(\Gamify\Question::PUBLISH_STATUS)
                                    @lang('admin/question/model.published_on', ['datetime' => old('publication_date', $question->publication_date)])
                                    @break
                                    @case(\Gamify\Question::FUTURE_STATUS)
                                    @lang('admin/question/model.scheduled_for', ['datetime' => old('publication_date', $question->publication_date)])
                                    @break
                                @endswitch
                            </span>
                        </div>
                        <div class="controls hidden" id="publicationDateControls">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                {!! Form::text('publication_date', $question->publication_date, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => __('admin/question/model.publication_date_placeholder')]) !!}
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

                </div>
                <div class="box-footer">
                    <a href="{{ route('admin.questions.index') }}" class="btn btn-primary">
                        @lang('button.back')
                    </a>
                    <button type="submit" class="btn btn-success pull-right" id="submitPublishBtn">
                        @if ($question->isPublishedOrScheduled())
                            @lang('button.update')
                        @else
                            @lang('button.publish')
                        @endif
                    </button>
                </div>

            </div>
            <!-- ./ publish section -->

            <!-- badges section -->
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin/question/title.badges_section')</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">

                    @include('admin/question/_form_actions')

                </div>
            </div>
            <!-- ./ badges section -->

            <!-- tags section -->
            <div class="box box-solid collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin/question/title.tags_section')</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('tags', __('admin/question/model.tags'), ['class' => 'control-label']) !!}
                        <div class="controls">
                            {!! Form::select('tags[]', $availableTags, null, ['class' => 'form-control', 'multiple' => 'multiple', 'id' => 'tag_list']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./ tags section -->

            <!-- other information section -->
            <div class="box box-solid collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('admin/question/title.other_section')</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    @if($question->isPublished())
                        <p>@lang('admin/question/model.published_on', ['datetime' => $question->publication_date->toDayDateTimeString()])</p>
                    @endif
                    <p>@lang('admin/question/model.updated_by', ['who' => $question->updater->name, 'when' => $question->updated_at->toDayDateTimeString()])</p>
                    <p>@lang('admin/question/model.created_by', ['who' => $question->creator->name, 'when' => $question->created_at->toDayDateTimeString()])</p>
                </div>
            </div>
            <!-- ./ other information section -->

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
            });

            $("#submitDraftBtn").click(function () {
                $("#status").val("draft");
                $("#formEditQuestion").submit();
            });

            $("#submitPublishBtn").click(function () {
                $("#status").val("publish");
                $("#formEditQuestion").submit();
            });

            $("#enableVisibilityControls").click(function () {
                $("#visibilityStatus").addClass("hidden");
                $("#visibilityControls").removeClass("hidden");
                $("#enableVisibilityControls").addClass("hidden");
            });

            $.datetimepicker.setLocale("@lang('site.dateTimePickerLang')");
            $("#publication_date").datetimepicker({
                minDate: 0,
                minTime: 0,
                format: "Y-m-d H:i",
                defaultTime:'09:00',
                closeOnDateSelect: true,
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
