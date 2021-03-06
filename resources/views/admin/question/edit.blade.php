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

                        <!-- link -->
                        <div class="form-group">
                            <p class="text-muted">
                                <b>@lang('admin/question/model.permanent_link')</b>: {{  $question->present()->public_url }}
                                <a href="{{ $question->present()->public_url }}"
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

                        @foreach ($question->actions as $action)
                            <tr>
                                <td>{{ \Gamify\Models\Badge::findOrFail($action->badge_id)->name }}</td>
                                <td>{{ \Gamify\Enums\QuestionActuators::getDescription($action->when) }}</td>
                                <td>
                                    <a href="{{ route('admin.questions.actions.destroy', [$question, $action]) }}"
                                       rel="nofollow" data-method="delete"
                                       data-confirm="@lang('admin/action/messages.confirm_delete')">
                                        <button type="button" class="btn btn-xs btn-danger" data-toggle="tooltip"
                                                data-placement="top" title="@lang('general.delete')">
                                            <i class="fa fa-times fa fa-white"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    <a href="{{ route('admin.questions.actions.create', $question) }}" class="btn btn-default pull-right">
                        <i class="fa fa-plus"></i> @lang('admin/action/title.create_new')
                    </a>

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
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
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
                                <span
                                    class="form-control-static">@lang('admin/question/model.status_list.' . $question->status)</span>
                                {!! Form::hidden('status', $question->status) !!}
                            </div>
                        </div>
                        <!-- ./ status -->

                        <!-- visibility -->
                        <div class="form-group {{ $errors->has('hidden') ? 'has-error' : '' }}">
                            {!! Form::label('hidden', __('admin/question/model.hidden'), ['class' => 'control-label required']) !!}
                            <a href="#" id="enableVisibilityControls">@lang('general.edit')</a>
                            <div id="visibilityStatus">
                            <span class="form-control-static">
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
                                        {{ Form::radio('hidden', '1', null, [ 'id' => 'visibilityPrivate', 'aria-describedby' => 'helpHiddenYes']) }}
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
                            @unless($question->isPublished())
                                <a href="#" id="enablePublicationDateControls">@lang('general.edit')</a>
                            @endunless
                            <div id="publicationDateStatus">
                            <span class="form-control-static">
                            @switch($question->status)
                                    @case(\Gamify\Models\Question::DRAFT_STATUS)
                                    @if (empty(old('publication_date')))
                                        @lang('admin/question/model.publish_immediately')
                                    @else
                                        @lang('admin/question/model.publish_on', ['datetime' => old('publication_date', $question->present()->publication_date)])
                                    @endif
                                    @break
                                    @case(\Gamify\Models\Question::PUBLISH_STATUS)
                                    @lang('admin/question/model.published_on', ['datetime' => old('publication_date', $question->present()->publication_date)])
                                    @break
                                    @case(\Gamify\Models\Question::FUTURE_STATUS)
                                    @lang('admin/question/model.scheduled_for', ['datetime' => old('publication_date', $question->present()->publication_date)])
                                    @break
                                @endswitch
                            </span>
                            </div>
                            <div class="controls hidden" id="publicationDateControls">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    {!! Form::text('publication_date', $question->present()->publication_date, ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => __('admin/question/model.publication_date_placeholder')]) !!}
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
                        @if ($question->isPublishedOrScheduled())
                            @lang('button.update')
                        @else
                            @lang('button.publish')
                        @endif
                    </button>
                </div>

            </div>
            <!-- ./ publish section -->

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
            $("#tags").select2({
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
