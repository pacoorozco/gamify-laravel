@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/question/title.question_edit'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/question/title.question_edit') }}
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li>
        <a href="{{ route('admin.questions.index') }}">
            {{ __('admin/site.questions') }}
        </a>
    </li>
    <li class="active">
        {{ __('admin/question/title.question_edit') }}
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
        <div class="col-md-8">

            <!-- general section -->
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        {{ $question->name }}
                    </h2>
                    {{ $question->present()->visibilityBadge() }}
                    {{ $question->present()->statusBadge() }}

                    <a href="{{ route('questions.show', ['q_hash' => $question->hash, 'slug' => $question->slug]) }}"
                       class="btn btn-link pull-right" target="_blank">
                        {{ __('general.view') }} <i class="fa fa-external-link"></i>
                    </a>
                </div>
                <div class="box-body">

                    <fieldset>
                        <legend>
                            {{ __('admin/question/title.general_section') }}
                        </legend>

                        <!-- name -->
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            {!! Form::label('name', __('admin/question/model.name'), ['class' => 'control-label required']) !!}
                            <p class="text-muted">{{ __('admin/question/model.name_help') }}</p>
                            <div class="controls">
                                {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                            </div>
                        </div>
                        <!-- ./ name -->

                        <!-- link -->
                        <div class="form-group">
                            <p class="text-muted">
                                <b>{{ __('admin/question/model.permanent_link') }}</b>: {{ route('questions.show', ['q_hash' => $question->hash, 'slug' => $question->slug]) }}
                                <a href="{{ route('questions.show', ['q_hash' => $question->hash, 'slug' => $question->slug]) }}"
                                   class="btn btn-default btn-xs" target="_blank">
                                    {{ __('general.view') }} <i class="fa fa-external-link"></i>
                                </a>
                            </p>
                        </div>
                        <!-- ./link -->

                        <!-- question text -->
                        <div class="form-group {{ $errors->has('question') ? 'has-error' : '' }}">
                            {!! Form::label('question', __('admin/question/model.question'), ['class' => 'control-label required']) !!}
                            <p class="text-muted">{{ __('admin/question/model.question_help') }}</p>
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
                            {{ __('admin/question/title.optional_section') }}
                        </legend>

                        <!-- solution -->
                        <div class="form-group {{ $errors->has('solution') ? 'has-error' : '' }}">
                            {!! Form::label('solution', __('admin/question/model.solution'), ['class' => 'control-label']) !!}
                            <p class="text-muted">{{ __('admin/question/model.solution_help') }}</p>
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
                                <x-tags.form-select-tags name="tags"
                                                         :placeholder="__('admin/question/model.tags_help')"
                                                         :selected-tags="old('tags', $question->tagArrayNormalized)"
                                                         class="form-control"
                                />
                            </div>
                        </div>
                        <!-- ./ tags -->

                    </fieldset>
                </div>
            </div>
            <!-- ./ general section -->

        </div>
        <div class="col-md-4">

            <!-- publish section -->
            <div class="box box-solid">
                <div class="box-body">

                    <fieldset>
                        <legend>
                            {{ __('admin/question/title.publish_section') }}
                        </legend>

                        <!-- save draft and preview -->
                        <div class="form-group">
                            @if ($question->isPublished())
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#saveAsDraftConfirmationModal">
                                    {{ __('button.save_as_draft') }}
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
                                                    {{ __('admin/question/title.un-publish_confirmation') }}
                                                </h4>
                                            </div>
                                            <div class="modal-body">
                                                {{ __('admin/question/messages.un-publish_confirmation_notice') }}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                                    {{ __('general.close') }}
                                                </button>
                                                <button type="button" class="btn btn-primary" id="submitDraftBtn">
                                                    {{ __('admin/question/messages.un-publish_confirmation_button') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ./ modal: saveAsDraftConfirmationModal -->
                                </div>
                            @else
                                <button type="button" class="btn btn-primary" id="submitDraftBtn">
                                    {{ __('button.save_as_draft') }}
                                </button>
                            @endif
                        </div>
                        <!-- ./ save draft and preview -->

                        <!-- status -->
                        <div class="form-group">
                            {!! Form::label('status', __('admin/question/model.status'), ['class' => 'control-label']) !!}
                            <div class="controls">
                                <span
                                    class="form-control-static">{{ __('admin/question/model.status_list.' . $question->status) }}</span>
                                {!! Form::hidden('status', $question->status) !!}
                            </div>
                        </div>
                        <!-- ./ status -->

                        <!-- visibility -->
                        <div class="form-group {{ $errors->has('hidden') ? 'has-error' : '' }}">
                            {!! Form::label('hidden', __('admin/question/model.hidden'), ['class' => 'control-label required']) !!}
                            <a href="#" id="enableVisibilityControls">{{ __('general.edit') }}</a>
                            <div id="visibilityStatus">
                            <span class="form-control-static">
                                {{ old('hidden', $question->hidden ? '1' : '0') === '1' ? __('admin/question/model.hidden_yes') : __('admin/question/model.hidden_no') }}
                            </span>
                            </div>
                            <div class="controls hidden" id="visibilityControls">
                                <div class="radio">
                                    <label class="control-label">
                                        {{ Form::radio('hidden', '0', null, [ 'id' => 'visibilityPublic']) }}
                                        {{ __('admin/question/model.hidden_no') }}
                                    </label>
                                </div>
                                <div class="radio">
                                    <label class="control-label">
                                        {{ Form::radio('hidden', '1', null, [ 'id' => 'visibilityPrivate', 'aria-describedby' => 'helpHiddenYes']) }}
                                        {{ __('admin/question/model.hidden_yes') }}
                                    </label>
                                    <span id="helpHiddenYes"
                                          class="text-muted">{{ __('admin/question/model.hidden_yes_help') }}</span>
                                </div>
                            </div>
                            <span class="help-block">{{ $errors->first('hidden', ':message') }}</span>
                        </div>
                        <!-- ./ visibility -->

                        <!-- publication date -->
                        <div class="form-group {{ $errors->has('publication_date') ? 'has-error' : '' }}">
                            {!! Form::label('publication_date', __('admin/question/model.publication_date'), ['class' => 'control-label']) !!}
                            @unless($question->isPublished())
                                <a href="#" id="enablePublicationDateControls">{{ __('general.edit') }}</a>
                            @endunless
                            <div id="publicationDateStatus">
                            <span class="form-control-static">
                            @switch($question->status)
                                    @case(\Gamify\Models\Question::DRAFT_STATUS)
                                        @if (empty(old('publication_date')))
                                            {{ __('admin/question/model.publish_immediately') }}
                                        @else
                                            {{ __('admin/question/model.publish_on', ['datetime' => old('publication_date', $question->present()->publicationDate())]) }}
                                        @endif
                                        @break
                                    @case(\Gamify\Models\Question::PUBLISH_STATUS)
                                        {{ __('admin/question/model.published_on', ['datetime' => old('publication_date', $question->present()->publicationDate())]) }}
                                        @break
                                    @case(\Gamify\Models\Question::FUTURE_STATUS)
                                        {{ __('admin/question/model.scheduled_for', ['datetime' => old('publication_date', $question->present()->publicationDate())]) }}
                                        @break
                                @endswitch
                            </span>
                            </div>
                            <div class="controls hidden" id="publicationDateControls">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    {!! Form::text('publication_date', $question->present()->publicationDate(), ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => __('admin/question/model.publication_date_placeholder')]) !!}
                                    <span class="input-group-btn">
                                    <button type="button" class="btn btn-flat" id="resetPublicationDateBtn">
                                        {{ __('admin/question/model.publish_immediately') }}
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
                    <button type="submit" class="btn btn-success" id="submitPublishBtn">
                        @if ($question->isPublished() || $question->isScheduled())
                            {{ __('button.update') }}
                        @else
                            {{ __('button.publish') }}
                        @endif
                    </button>

                    <a href="{{ route('admin.questions.index') }}" class="btn btn-link">
                        {{ __('button.back') }}
                    </a>
                </div>

            </div>
            <!-- ./ publish section -->

            <!-- badges section -->
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('admin/question/title.badges_section') }}</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">

                    <dl>
                        <dt>{{ __('admin/question/model.tags') }}</dt>
                        <dd>
                            {{ $question->present()->tags() }}
                        </dd>
                    </dl>

                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>{{ __('admin/badge/model.name') }}</th>
                            <th>{{ __('admin/badge/model.actuators') }}</th>
                            <th>{{ __('admin/badge/model.tags') }}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($relatedBadges as $badge)
                            <tr>
                                <td>{{ $badge->name }}</td>
                                <td>{{ $badge->actuators->description }}</td>
                                <td>
                                    {{ $badge->present()->tagsIn($question->tagArrayNormalized) }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- ./ badges section -->


            <!-- other information section -->
            <div class="box box-solid collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('admin/question/title.other_section') }}</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    @if($question->isPublished())
                        <p>
                            {{ __('admin/question/model.published_on', ['datetime' => $question->present()->publicationDate()]) }}
                        </p>
                    @endif
                    <p>
                        {{ __('admin/question/model.updated_by', ['who' => $question->present()->updater(), 'when' => $question->updated_at->toDayDateTimeString()]) }}
                    </p>
                    <p>
                        {{ __('admin/question/model.created_by', ['who' => $question->present()->creator(), 'when' => $question->created_at->toDayDateTimeString()]) }}
                    </p>
                </div>
            </div>
            <!-- ./ other information section -->

            <!-- danger zone -->
            <div class="box box-solid box-danger">
                <div class="box-header">
                    <strong>@lang('admin/question/messages.danger_zone_section')</strong>
                </div>
                <div class="box-body">
                    <p><strong>@lang('admin/question/messages.delete_button')</strong></p>
                    <p>@lang('admin/question/messages.delete_help')</p>

                    <div class="text-center">
                        <button type="button" class="btn btn-danger"
                                data-toggle="modal"
                                data-target="#confirmationModal">
                            @lang('admin/question/messages.delete_button')
                        </button>
                    </div>
                </div>
            </div>
            <!-- ./danger zone -->

        </div>
    </div>

    {!! Form::close() !!}

    <!-- confirmation modal -->
    <x-modals.confirmation
        action="{{ route('admin.questions.destroy', $question) }}"
        confirmationText="{{ $question->name }}"
        buttonText="{{ __('admin/question/messages.delete_confirmation_button') }}">

        <div class="alert alert-warning" role="alert">
            @lang('admin/question/messages.delete_confirmation_warning', ['name' => $question->name])
        </div>
    </x-modals.confirmation>
    <!-- ./ confirmation modal -->
@endsection

{{-- Styles --}}
@push('styles')
    <link rel="stylesheet"
          href="{{ asset('vendor/jquery-datetimepicker/jquery.datetimepicker.min.css') }}">

    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote.min.css') }}">
@endpush

{{-- Scripts --}}
@push('scripts')
    <script
        src="{{ asset('vendor/jquery-datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>

    <script src="{{ asset('vendor/summernote/summernote.min.js') }}"></script>

    <script>
        $(function () {
            $('.editor').summernote();

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

            $.datetimepicker.setLocale("{{ __('site.dateTimePickerLang') }}");
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
