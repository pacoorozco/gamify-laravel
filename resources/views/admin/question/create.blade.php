@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/question/title.create_a_new_question'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/question/title.create_a_new_question') }}
    <small class="text-muted">create a new question</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.home') }}">
            {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.questions.index') }}">
            {{ __('admin/site.questions') }}
        </a>
    </li>
    <li class="breadcrumb-item active">
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
                <div class="card">
                    <div class="card-body">

                        <fieldset>
                            <x-forms.legend>
                                {{ __('admin/question/title.general_section') }}
                            </x-forms.legend>

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
                            <x-forms.legend>
                                {{ __('admin/question/title.optional_section') }}
                            </x-forms.legend>

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
                            />
                            <!-- ./ tags -->

                        </fieldset>
                    </div>
                </div>
                <!-- ./ general section -->

            </div>
            <div class="col-md-4">

                <!-- publish section -->
                <div class="card">
                    <div class="card-body">

                        <fieldset>
                            <x-forms.legend>
                                {{ __('admin/question/title.publish_section') }}
                            </x-forms.legend>

                            <!-- save draft and preview -->
                            <div class="form-group">
                                <x-forms.submit type="secondary" :value="__('general.save_as_draft')"
                                                id="submitDraftBtn"/>
                            </div>
                            <!-- ./ save draft and preview -->

                            <!-- status -->
                            <div class="form-group row">
                                <x-forms.label for="status"
                                               class="col-2 col-form-label">{{ __('admin/question/model.status') }}</x-forms.label>
                                <span
                                    class="col form-control-plaintext">{{ __('admin/question/model.status_list.draft') }}</span>
                                <x-forms.input-hidden name="status" value="draft"/>
                            </div>
                            <!-- ./ status -->

                            <!-- visibility -->
                            <div class="form-group">
                                <x-forms.label for="hidden">{{ __('admin/question/model.hidden') }}</x-forms.label>
                                <a href="#" id="enableVisibilityControls">{{ __('general.edit') }}</a>
                                <div id="visibilityStatus" class="form-control-plaintext">
                                    {{ old('hidden') == '1' ? __('admin/question/model.hidden_yes') : __('admin/question/model.hidden_no') }}
                                </div>
                                <div id="visibilityControls" class="d-none">
                                    <x-forms.radio
                                        name="hidden"
                                        :label="__('admin/question/model.hidden_no')"
                                        value="0"
                                        :checked="old('hidden', '0') == '0'"
                                        id="visibilityPublic"/>

                                    <x-forms.radio
                                        name="hidden"
                                        :label="__('admin/question/model.hidden_yes')"
                                        :help="__('admin/question/model.hidden_yes_help')"
                                        value="1"
                                        :checked="old('hidden', '0') == '1'"
                                        id="visibilityPrivate"/>
                                </div>
                            </div>
                            <!-- ./ visibility -->

                            <!-- publication date -->
                            <div class="form-group">
                                <x-forms.label for="publication_date">
                                    {{ __('admin/question/model.publication_date') }}
                                </x-forms.label>
                                <a href="#" id="enablePublicationDateControls">{{ __('general.edit') }}</a>

                                <div id="publicationDateStatus" class="form-control-plaintext">
                                    {{ empty(old('publication_date')) ? __('admin/question/model.publish_immediately') : __('admin/question/model.publish_on', ['datetime' => old('publication_date')]) }}
                                </div>

                                <div id="publicationDateControls" class="d-none">
                                    <x-forms.date-time-picker
                                        name="publication_date"
                                        id="publication_date"
                                        :label="__('admin/question/model.publication_date')"
                                        :placeholder="__('admin/question/model.publication_date_placeholder')"/>
                                    <small class="text-muted">
                                        {{ __('admin/question/model.publication_date_help') }}
                                    </small>
                                </div>

                                <x-forms.error name="publication_date"/>
                            </div>
                            <!-- ./ publication date -->
                        </fieldset>

                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('admin.questions.index') }}" class="btn btn-link">
                            {{ __('general.cancel') }}
                        </a>
                        <button type="submit" class="btn btn-primary" id="submitPublishBtn">
                            <i class="bi bi-send-fill"></i> {{ __('admin/question/model.publish') }}
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
    <link rel="stylesheet" href="{{ asset('vendor/AdminLTE/plugins/summernote/summernote-bs4.min.css') }}">
@endpush

{{-- Scripts --}}
@push('scripts')
    <script src="{{ asset('vendor/AdminLTE/plugins/summernote/summernote-bs4.min.js') }}"></script>

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
                $("#visibilityStatus").addClass("d-none");
                $("#visibilityControls").removeClass("d-none");
                $("#enableVisibilityControls").addClass("d-none");
            });

            $("#enablePublicationDateControls").click(function () {
                $("#publicationDateStatus").addClass("d-none");
                $("#publicationDateControls").removeClass("d-none");
                $("#enablePublicationDateControls").addClass("d-none");
            });
        });
    </script>
@endpush
