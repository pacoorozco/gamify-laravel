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

    <x-forms.form method="post" :action="route('admin.questions.store')" id="formCreateQuestion" hasFiles>

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
                                class="editor"
                                style="width: 100%"
                                :required="true"/>
                            <!-- ./ question text -->

                            <!-- type -->
                            <x-forms.select name='type'
                                            :label="__('admin/question/model.type')"
                                            :help="__('admin/question/model.type_help')"
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
                                                 :help="__('admin/question/model.tags_help')"
                                                 :placeholder="__('admin/question/model.tags_placeholder')"
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
                                <button type="button"
                                        id="submitDraftBtn"
                                        class="btn btn-secondary">
                                    {{ __('general.save_as_draft') }}
                                </button>
                            </div>
                            <!-- ./ save draft and preview -->

                            <!-- status -->
                            <div class="form-group row">
                                <x-forms.label for="status"
                                               class="col-2 col-form-label">{{ __('admin/question/model.status') }}</x-forms.label>
                                <span
                                    class="col form-control-plaintext">{{ __('admin/question/model.status_list.draft') }}</span>
                                <x-forms.input-hidden id="status" name="status" value="draft"/>
                            </div>
                            <!-- ./ status -->

                            <!-- visibility -->
                            <x-forms.visibility
                                name="hidden"
                                :value="0"/>
                            <!-- ./ visibility -->

                            <!-- publication date -->
                            <x-forms.publication-date
                                name="publication_date"/>
                            <!-- ./ publication date -->
                        </fieldset>

                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('admin.questions.index') }}" class="btn btn-link">
                            {{ __('general.cancel') }}
                        </a>
                        <button type="button" class="btn btn-primary" id="submitPublishBtn">
                            {{ __('admin/question/model.publish') }}
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
        });
    </script>
@endpush
