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
            <i class="bi bi-house-fill"></i> {{ __('admin/site.dashboard') }}
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

    <x-forms.form method="put" :action="route('admin.questions.update', $question)" id="formEditQuestion">

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
                            {{ __('general.view') }} <i class="bi bi-box-arrow-right-up"></i>
                        </a>
                    </div>
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
                                value="{{ $question->name }}"
                                :required="true"/>
                            <!-- ./ name -->

                            <!-- link -->
                            <div class="form-group">
                                <p class="text-muted">
                                    <b>{{ __('admin/question/model.permanent_link') }}</b>: {{ route('questions.show', ['q_hash' => $question->hash, 'slug' => $question->slug]) }}
                                    <a href="{{ route('questions.show', ['q_hash' => $question->hash, 'slug' => $question->slug]) }}"
                                       class="btn btn-default btn-xs" target="_blank">
                                        {{ __('general.view') }} <i class="bi bi-box-arrow-right-up"></i>
                                    </a>
                                </p>
                            </div>
                            <!-- ./link -->

                            <!-- question text -->
                            <x-forms.textarea
                                name="question"
                                :label="__('admin/question/model.question')"
                                :help="__('admin/question/model.question_help')"
                                value="{!! $question->question !!}"
                                style="width: 100%"
                                :required="true"/>
                            <!-- ./ question text-->

                            <!-- type -->
                            <x-forms.select name='type'
                                            :label="__('admin/question/model.type')"
                                            :options="__('admin/question/model.type_list')"
                                            selectedKey="{{ $question->type }}"
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
                                                 :selected-tags="old('tags', $question->tagArrayNormalized)"
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
                                @if ($question->isPublished())
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#saveAsDraftConfirmationModal">
                                        {{ __('button.save_as_draft') }}
                                    </button>
                                    <!-- modal: saveAsDraftConfirmationModal -->
                                    <div class="modal fade" id="saveAsDraftConfirmationModal" tabindex="-1"
                                         role="dialog"
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
                                <x-forms.label for="status">{{ __('admin/question/model.status') }}</x-forms.label>
                                <span
                                    class="form-control-static">{{ __('admin/question/model.status_list.' . $question->status) }}</span>
                                <x-forms.input-hidden name="status" value="{{ $question->status }}"/>
                            </div>
                            <!-- ./ status -->

                            <!-- visibility -->
                            <div class="form-group @error('hidden') has-error @enderror">
                                <x-forms.label for="hidden">{{ __('admin/question/model.hidden') }}</x-forms.label>
                                <a href="#" id="enableVisibilityControls">{{ __('general.edit') }}</a>
                                <div id="visibilityStatus">
                            <span class="form-control-static">
                                {{ old('hidden', $question->hidden ? '1' : '0') == '1' ? __('admin/question/model.hidden_yes') : __('admin/question/model.hidden_no') }}
                            </span>
                                </div>
                                <div class="controls hidden" id="visibilityControls">
                                    <x-forms.radio
                                        name="hidden"
                                        :label="__('admin/question/model.hidden_no')"
                                        value="0"
                                        :checked="old('hidden', $question->hidden ? '1' : '0') == '0'"
                                        id="visibilityPublic"/>

                                    <x-forms.radio
                                        name="hidden"
                                        :label="__('admin/question/model.hidden_yes')"
                                        :help="__('admin/question/model.hidden_yes_help')"
                                        value="1"
                                        :checked="old('hidden', $question->hidden ? '1' : '0') == '0'"
                                        id="visibilityPrivate"/>
                                </div>
                                <x-forms.error name="hidden"></x-forms.error>
                            </div>
                            <!-- ./ visibility -->

                            <!-- publication date -->
                            <div class="form-group {{ $errors->has('publication_date') ? 'has-error' : '' }}">
                                <x-forms.label for="publication_date">{{ __('admin/question/model.publication_date') }}</x-forms.label>
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
                                            <i class="bi bi-calendar-fill"></i>
                                        </div>
                                        <input name="publication_date"
                                               id="publication_date"
                                               type="text"
                                               class="form-control"
                                               autocomplete="off"
                                               placeholder="{{ __('admin/question/model.publication_date_placeholder') }}"
                                               value="{{ old('publication_date', $question->present()->publicationDate()) }}"
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
                                <i class="bi bi-dash"></i>
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
                                <i class="bi bi-plus"></i>
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
                        <strong>{{ __('admin/question/messages.danger_zone_section') }}</strong>
                    </div>
                    <div class="box-body">
                        <p><strong>{{ __('admin/question/messages.delete_button') }}</strong></p>
                        <p>{{ __('admin/question/messages.delete_help') }}</p>

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
        action="{{ route('admin.questions.destroy', $question) }}"
        confirmationText="{{ $question->name }}"
        buttonText="{{ __('admin/question/messages.delete_confirmation_button') }}">

        <div class="alert alert-warning" role="alert">
            {{ __('admin/question/messages.delete_confirmation_warning', ['name' => $question->name]) }}
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
