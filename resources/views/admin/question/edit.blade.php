@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/question/title.question_edit'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/question/title.question_edit') }}
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
        {{ __('admin/question/title.question_edit') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    <x-forms.form method="put" :action="route('admin.questions.update', $question)" id="formEditQuestion" hasFiles>

        <div class="row">
            <div class="col-md-8">

                <!-- general section -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">
                            {{ $question->name }} {{ $question->present()->visibilityBadge() }} {{ $question->present()->statusBadge() }}
                        </h2>
                        <div class="card-tools">
                            <a href="{{ route('questions.show', ['q_hash' => $question->hash, 'slug' => $question->slug]) }}"
                               class="btn btn-tool" target="_blank">
                                {{ __('general.view') }} <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">

                        <fieldset>
                            <x-forms.legend class="mb-4">
                                {{ __('admin/question/title.general_section') }}
                            </x-forms.legend>

                            <!-- name -->
                            <x-forms.input
                                name="name"
                                :label="__('admin/question/model.name')"
                                :help="__('admin/question/model.name_help')"
                                :value="$question->name"
                                :required="true"/>
                            <!-- ./ name -->

                            <!-- link -->
                            <div class="form-group">
                                <small class="text-muted">
                                    <b>{{ __('admin/question/model.permanent_link') }}</b>: {{ route('questions.show', ['q_hash' => $question->hash, 'slug' => $question->slug]) }}
                                    <a href="{{ route('questions.show', ['q_hash' => $question->hash, 'slug' => $question->slug]) }}"
                                       class="btn btn-default btn-xs" target="_blank">
                                        {{ __('general.view') }} <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                </small>
                            </div>
                            <!-- ./link -->

                            <!-- question text -->
                            <x-forms.textarea
                                name="question"
                                :label="__('admin/question/model.question')"
                                :help="__('admin/question/model.question_help')"
                                value="{!! $question->question !!}"
                                class="editor"
                                style="width: 100%"
                                :required="true"/>
                            <!-- ./ question text-->

                            <!-- type -->
                            <x-forms.select name='type'
                                            :label="__('admin/question/model.type')"
                                            :help="__('admin/question/model.type_help')"
                                            :options="__('admin/question/model.type_list')"
                                            :selectedKey="$question->type"
                                            :required="true"/>
                            <!-- ./ type -->
                        </fieldset>

                        <!-- options -->
                        @include('admin/question/_form_choices')
                        <!-- ./ options -->

                        <fieldset>
                            <x-forms.legend class="mb-4">
                                {{ __('admin/question/title.answer_section') }}
                                {{ __('admin/question/title.optional_section') }}
                            </x-forms.legend>

                            <!-- solution -->
                            <x-forms.textarea
                                name="solution"
                                :label="__('admin/question/model.solution')"
                                :help="__('admin/question/model.solution_help')"
                                value="{!! $question->solution !!}"
                                class="editor"
                                style="width: 100%"
                                :required="true"/>
                            <!-- ./ solution -->

                            <!-- tags -->
                            <x-forms.select-tags name="tags"
                                                 :label="__('admin/question/model.tags')"
                                                 :help="__('admin/badge/model.tags_help')"
                                                 :placeholder="__('admin/question/model.tags_help')"
                                                 :selected-tags="old('tags', $question->tagArrayNormalized)"/>
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
                                @if ($question->isPublished())
                                    <button type="button"
                                            class="btn btn-secondary"
                                            data-toggle="modal"
                                            data-target="#saveAsDraftConfirmationModal">
                                        {{ __('general.save_as_draft') }}
                                    </button>
                                    <!-- modal: saveAsDraftConfirmationModal -->
                                    <div class="modal" id="saveAsDraftConfirmationModal" tabindex="-1"
                                         aria-labelledby="saveAsDraftConfirmationModalLabel">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="saveAsDraftConfirmationModalLabel">
                                                        {{ __('admin/question/title.un-publish_confirmation') }}
                                                    </h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ __('admin/question/messages.un-publish_confirmation_notice') }}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-link" data-dismiss="modal">
                                                        {{ __('general.cancel') }}
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
                                    <button type="button"
                                            id="submitDraftBtn"
                                            class="btn btn-secondary">
                                        {{ __('general.save_as_draft') }}
                                    </button>
                                @endif
                            </div>
                            <!-- ./ save draft and preview -->

                            <!-- status -->
                            <div class="form-group row">
                                <x-forms.label for="status" class="col-2 col-form-label">
                                    {{ __('admin/question/model.status') }}
                                </x-forms.label>
                                <span
                                    class="col form-control-plaintext">{{ __('admin/question/model.status_list.' . $question->status) }}</span>
                                <x-forms.input-hidden id="status" name="status" value="{{ $question->status }}"/>
                            </div>
                            <!-- ./ status -->

                            <!-- visibility -->
                            <x-forms.visibility
                                name="hidden"
                                :value="$question->hidden"/>
                            <!-- ./ visibility -->

                            <!-- publication date -->
                            <div class="form-group">
                                <x-forms.label for="publication_date">
                                    {{ __('admin/question/model.publication_date') }}
                                </x-forms.label>
                                @unless($question->isPublished())
                                    <a href="#" id="enablePublicationDateControls">{{ __('general.edit') }}</a>
                                @endunless
                                <div id="publicationDateStatus" class="form-control-plaintext">
                                    @switch($question->status)
                                        @case(\Gamify\Models\Question::DRAFT_STATUS)
                                            {{ empty(old('publication_date')) ? __('admin/question/model.publish_immediately') : __('admin/question/model.publish_on', ['datetime' => old('publication_date', $question->present()->publicationDate())]) }}
                                            @break
                                        @case(\Gamify\Models\Question::PUBLISH_STATUS)
                                            {{ __('admin/question/model.published_on', ['datetime' => old('publication_date', $question->present()->publicationDate())]) }}
                                            @break
                                        @case(\Gamify\Models\Question::FUTURE_STATUS)
                                            {{ __('admin/question/model.scheduled_for', ['datetime' => old('publication_date', $question->present()->publicationDate())]) }}
                                            @break
                                    @endswitch
                                </div>

                                <div id="publicationDateControls" class="d-none">
                                    <x-forms.date-time-picker
                                        name="publication_date"
                                        id="publication_date"
                                        :value="$question->present()->publicationDate()"
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

                        <button type="button" class="btn btn-primary" id="submitPublishBtn">
                            @if ($question->isPublished() || $question->isScheduled())
                                {{ __('general.update') }}
                            @else
                                {{ __('admin/question/model.publish') }}
                            @endif
                        </button>
                    </div>

                </div>
                <!-- ./ publish section -->

                <!-- badges section -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('admin/question/title.badges_section') }}</h3>
                        <div class="card-tools float-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="bi bi-dash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">

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
                                    <td>{{ $badge->actuators->label() }}</td>
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
                <div class="card collapsed-box">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('admin/question/title.other_section') }}</h3>
                        <div class="card-tools float-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
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
                <div class="card">
                    <div class="card-header bg-danger">
                        <strong>{{ __('admin/question/messages.danger_zone_section') }}</strong>
                    </div>
                    <div class="card-body">
                        <p><strong>{{ __('admin/question/messages.delete_button') }}</strong></p>
                        <p>{!! __('admin/question/messages.delete_help') !!}</p>

                        <div class="text-center">
                            <button type="button" class="btn btn-danger"
                                    data-toggle="modal"
                                    data-target="#confirmationModal">
                                {{ __('admin/question/messages.delete_button') }}
                            </button>
                        </div>
                    </div>
                </div>
                <!-- ./danger zone -->

            </div>
        </div>

    </x-forms.form>

    <!-- confirmation modal -->
    <x-modals.confirmation
        :action="route('admin.questions.destroy', $question)"
        :confirmationText="$question->name"
        :buttonText="__('admin/question/messages.delete_confirmation_button')">

        <div class="alert alert-warning" role="alert">
            {!! __('admin/question/messages.delete_confirmation_warning', ['name' => $question->name]) !!}
        </div>
    </x-modals.confirmation>
    <!-- ./ confirmation modal -->
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
                $("#formEditQuestion").submit();
            });

            $("#submitPublishBtn").click(function () {
                $("#status").val("publish");
                $("#formEditQuestion").submit();
            });

            $("#enablePublicationDateControls").click(function () {
                $("#publicationDateStatus").addClass("d-none");
                $("#publicationDateControls").removeClass("d-none");
            });
        });
    </script>
@endpush
