@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/question/title.create_a_new_question'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/question/title.create_a_new_question') }}
    <small>create a new question</small>
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
        {{ __('admin/question/title.create_a_new_question') }}
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
        <div class="col-md-8">

            <!-- general section -->
            <div class="box box-solid">
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

                        <!-- question text -->
                        <div class="form-group {{ $errors->has('question') ? 'has-error' : '' }}">
                            {!! Form::label('question', __('admin/question/model.question'), ['class' => 'control-label required']) !!}
                            <p class="text-muted">{{ __('admin/question/model.question_help') }}</p>
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
                                                         :selected-tags="old('tags', [])"
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
                            <button type="submit" class="btn btn-primary" id="submitDraftBtn">
                                {{ __('button.save_as_draft') }} <i class="fa fa-floppy-o"></i>
                            </button>
                        </div>
                        <!-- ./ save draft and preview -->

                        <!-- status -->
                        <div class="form-group">
                            {!! Form::label('status', __('admin/question/model.status'), ['class' => 'control-label required']) !!}
                            <div class="controls">
                                <span
                                    class="form-control-static">{{ __('admin/question/model.status_list.draft') }}</span>
                                {!! Form::hidden('status','draft') !!}
                            </div>
                        </div>
                        <!-- ./ status -->

                        <!-- visibility -->
                        <div class="form-group {{ $errors->has('hidden') ? 'has-error' : '' }}">
                            {!! Form::label('hidden', __('admin/question/model.hidden'), ['class' => 'control-label required']) !!}
                            <a href="#" id="enableVisibilityControls">{{ __('general.edit') }}</a>
                            <div id="visibilityStatus">
                            <span class="form-control-static">
                                {{ old('hidden') === '1' ? __('admin/question/model.hidden_yes') : __('admin/question/model.hidden_no') }}
                            </span>
                            </div>
                            <div class="controls hidden" id="visibilityControls">
                                <div class="radio">
                                    <label class="control-label">
                                        {{ Form::radio('hidden', '0', true, [ 'id' => 'visibilityPublic']) }}
                                        {{ __('admin/question/model.hidden_no') }}
                                    </label>
                                </div>
                                <div class="radio">
                                    <label class="control-label">
                                        {{ Form::radio('hidden', '1', false, [ 'id' => 'visibilityPrivate', 'aria-describedby' => 'helpHiddenYes']) }}
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
                            <a href="#" id="enablePublicationDateControls">{{ __('general.edit') }}</a>
                            <div id="publicationDateStatus">
                            <span class="form-control-static">
                            @if (empty(old('publication_date')))
                                    {{ __('admin/question/model.publish_immediately') }}
                                @else
                                    {{ __('admin/question/model.publish_on', ['datetime' => old('publication_date')]) }}
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
                    <a href="{{ route('admin.questions.index') }}" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> {{ __('button.back') }}
                    </a>
                    <button type="submit" class="btn btn-success pull-right" id="submitPublishBtn">
                        <i class="fa fa-paper-plane-o"></i> {{ __('button.publish') }}
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
