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
            <i class="bi bi-house-fill"></i> {{ __('admin/site.dashboard') }}
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

    <x-forms.form method="post" :action="route('admin.questions.store')" id="formCreateQuestion">

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
                            <x-forms.input
                                name="name"
                                :label="__('admin/question/model.name')"
                                :help="__('admin/question/model.name_help')"
                                :required="true"/>
                            <!-- ./ name -->

                            <!-- question text -->
                            <x-forms.textarea
                                name="question"
                                :label="__('admin/question/model.question')"
                                :help="__('admin/question/model.question_help')"
                                style="width: 100%"
                                :required="true"/>
                            <!-- ./ question text -->

                            <!-- type -->
                            <x-forms.select name='type'
                                            :label="__('admin/question/model.type')"
                                            :options="__('admin/question/model.type_list')"
                                            :required="true"/>
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
                            <x-forms.textarea
                                name="solution"
                                :label="__('admin/question/model.solution')"
                                :help="__('admin/question/model.solution_help')"
                                class="editor"
                                style="width: 100%"
                                :required="true"/>
                            <!-- ./ solution -->

                            <!-- tags -->
                            <x-forms.select-tags name="tags"
                                                 :label="__('admin/question/model.tags')"
                                                 :help="__('admin/badge/model.tags_help')"
                                                 :placeholder="__('admin/question/model.tags_help')"
                                                 :selected-tags="old('tags', [])"
                                                 class="form-control"
                            />
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
                                <x-forms.submit type="primary" :value="__('button.save')" id="submitDraftBtn">
                                    {{ __('button.save_as_draft') }} <i class="bi bi-floppy-fill"></i>
                                </x-forms.submit>
                            </div>
                            <!-- ./ save draft and preview -->

                            <!-- status -->
                            <div class="form-group">
                                <x-forms.label for="status">{{ __('admin/question/model.status') }}</x-forms.label>
                                <span
                                    class="form-control-static">{{ __('admin/question/model.status_list.draft') }}</span>
                                <x-forms.input-hidden name="status" value="draft" />
                            </div>
                            <!-- ./ status -->

                            <!-- visibility -->
                            <div class="form-group @error('hidden') has-error @enderror">
                                <x-forms.label for="hidden">{{ __('admin/question/model.hidden') }}</x-forms.label>
                                <a href="#" id="enableVisibilityControls">{{ __('general.edit') }}</a>
                                <div id="visibilityStatus">
                            <span class="form-control-static">
                                {{ old('hidden') == '1' ? __('admin/question/model.hidden_yes') : __('admin/question/model.hidden_no') }}
                            </span>
                                </div>
                                <div class="controls hidden" id="visibilityControls">
                                    <x-forms.radio
                                        name="hidden"
                                        :label="__('admin/question/model.hidden_no')"
                                        value="0"
                                        :checked="true"
                                        id="visibilityPublic"/>

                                    <x-forms.radio
                                        name="hidden"
                                        :label="__('admin/question/model.hidden_yes')"
                                        :help="__('admin/question/model.hidden_yes_help')"
                                        value="1"
                                        id="visibilityPrivate"/>
                                </div>
                                <x-forms.error name="hidden"></x-forms.error>
                            </div>
                            <!-- ./ visibility -->

                            <!-- publication date -->
                            <div class="form-group @error('publication_date') has-error @enderror">
                                <x-forms.label for="publication_date">{{ __('admin/question/model.publication_date') }}</x-forms.label>
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
                                            <i class="bi bi-calendar-fill"></i>
                                        </div>
                                        <input name="publication_date"
                                               id="publication_date"
                                               type="text"
                                               class="form-control"
                                               autocomplete="off"
                                               placeholder="{{ __('admin/question/model.publication_date_placeholder') }}"
                                               value="{{ old('publication_date') }}"
                                        />
                                        <span class="input-group-btn">
                                    <button type="button" class="btn btn-flat" id="resetPublicationDateBtn">
                                        {{ __('admin/question/model.publish_immediately') }}
                                    </button>
                                </span>
                                    </div>
                                </div>
                                <x-forms.error name="publication_date"></x-forms.error>
                            </div>
                            <!-- ./ publication date -->
                        </fieldset>

                    </div>
                    <div class="box-footer">
                        <a href="{{ route('admin.questions.index') }}" class="btn btn-default">
                            <i class="bi bi-arrow-left-circle-fill"></i> {{ __('button.back') }}
                        </a>
                        <button type="submit" class="btn btn-success pull-right" id="submitPublishBtn">
                            <i class="bi bi-send-fill"></i> {{ __('button.publish') }}
                        </button>
                    </div>

                </div>
                <!-- ./ publish section -->

            </div>
        </div>

    </x-forms.form>
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
