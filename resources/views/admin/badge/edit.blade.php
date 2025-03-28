@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/badge/title.badge_edit'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/badge/title.badge_edit') }}
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li>
        <a href="{{ route('admin.badges.index') }}">
            {{ __('admin/site.badges') }}
        </a>
    </li>
    <li class="active">
        {{ __('admin/badge/title.badge_edit') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    {{-- Edit Badge Form --}}
    <x-forms.form method="put" :action="route('admin.badges.update', $badge)" hasFiles>

        <div class="box box-solid">
            <div class="box-header with-border">
                <h2 class="box-title">
                    {{ $badge->present()->nameWithStatusBadge() }}
                </h2>
            </div>
            <div class="box-body">
                <div class="row">

                    <!-- right column -->
                    <div class="col-md-6">

                        <fieldset>
                            <!-- name -->
                            <x-forms.input name="name" :label="__('admin/badge/model.name')" value="{{ $badge->name }}"
                                           :required="true"/>
                            <!-- ./ name -->

                            <!-- description -->
                            <x-forms.textarea name="description" :label="__('admin/badge/model.description')"
                                              value="{{ $badge->description }}"
                                              :required="true"/>
                            <!-- ./ description -->
                        </fieldset>

                        <fieldset>
                            <!-- required_repetitions -->
                            <x-forms.input type="number" name="required_repetitions"
                                           :label="__('admin/badge/model.required_repetitions')"
                                           :help="__('admin/badge/model.required_repetitions_help')"
                                           min="1"
                                           value="{{ $badge->required_repetitions }}"
                                           :required="true"/>
                            <!-- ./ required_repetitions -->

                            <!-- actuators -->
                            <x-forms.select name='actuators'
                                            :label="__('admin/badge/model.actuators')"
                                            :help="__('admin/badge/model.actuators_help')"
                                            :options="\Gamify\Enums\BadgeActuators::toSelectArray()"
                                            selectedKey="{{ $badge->actuators->value }}"
                                            class="tags-actuators"
                                            :required="true"/>
                            <!-- ./ actuators -->

                            <!-- tags -->
                            <x-forms.select-tags name="tags"
                                                 :label="__('admin/badge/model.tags')"
                                                 :help="__('admin/badge/model.tags_help')"
                                                 :placeholder="__('admin/badge/model.tags_placeholder')"
                                                 :selected-tags="old('tags', $badge->tagArrayNormalized)"
                                                 class="form-control"
                            />
                            <!-- ./ tags -->
                        </fieldset>

                    </div>
                    <!-- ./left column -->

                    <!-- right column -->
                    <div class="col-md-6">

                        <!-- image -->
                        <x-forms.input-group :hasError="$errors->has('image')">
                            <x-forms.label for="image" :value="__('admin/badge/model.image')"/>
                            <p class="text-muted">{{ __('admin/badge/model.image_help') }}</p>
                            <div class="controls">
                                <p class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                         style="width: 150px; height: 150px;">
                                        {{ $badge->present()->imageTag() }}
                                    </div>

                                    <!-- image buttons -->
                                    <p>

                                <span class="btn btn-default btn-file">
                                    <span class="fileinput-new">
                                        <i class="fa fa-picture-o"></i> {{ __('button.pick_image') }}
                                    </span>
                                    <span class="fileinput-exists">
                                        <i class="fa fa-picture-o"></i> {{ __('button.upload_image') }}
                                    </span>
                                    <input type="file" name="image">
                                </span>
                                        <a href="#" class="fileinput-exists btn btn-default" data-dismiss="fileinput">
                                            <i class="fa fa-times"></i> {{ __('button.delete_image') }}
                                        </a>

                                    </p>
                                    <!-- ./image buttons -->

                                </div>
                            </div>
                            <span class="help-block">{{ $errors->first('image', ':message') }}</span>
                        </x-forms.input-group>
                        <!-- ./ image -->

                        <!-- status -->
                        <x-forms.select name='active'
                                        :label="__('admin/badge/model.active')"
                                        :options="['1' => __('general.yes'), '0' => __('general.no')]"
                                        selectedKey="{{ $badge->active ? '1' : '0' }}"
                                        :required="true"/>
                        <!-- ./ status -->

                        <!-- danger zone -->
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <strong>@lang('admin/badge/messages.danger_zone_section')</strong>
                            </div>
                            <div class="panel-body">
                                <p><strong>@lang('admin/badge/messages.delete_button')</strong></p>
                                <p>@lang('admin/badge/messages.delete_help')</p>

                                <div class="text-center">
                                    <button type="button" class="btn btn-danger"
                                            data-toggle="modal"
                                            data-target="#confirmationModal">
                                        @lang('admin/badge/messages.delete_button')
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- ./danger zone -->

                    </div>
                    <!-- ./right column -->

                </div>
            </div>

            <div class="box-footer">
                <!-- form actions -->
                <x-forms.submit type="success" :value="__('button.save')"/>

                <a href="{{ route('admin.badges.index') }}" class="btn btn-link" role="button">
                    {{ __('general.back') }}
                </a>
                <!-- ./ form actions -->
            </div>

        </div>
    </x-forms.form>

    <!-- confirmation modal -->
    <x-modals.confirmation
        action="{{ route('admin.badges.destroy', $badge) }}"
        confirmationText="{{ $badge->name }}"
        buttonText="{{ __('admin/badge/messages.delete_confirmation_button') }}">

        <div class="alert alert-warning" role="alert">
            @lang('admin/badge/messages.delete_confirmation_warning', ['name' => $badge->name])
        </div>
    </x-modals.confirmation>
    <!-- ./ confirmation modal -->
@endsection

{{-- Styles --}}
@push('styles')
    <link rel="stylesheet"
          href="{{ asset('vendor/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
@endpush

{{-- Scripts --}}
@push('scripts')
    <script
        src="{{ asset('vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>

    <script>
        $(function () {

            $('.tags-actuators').change(function () {
                $(this).find("option:selected").each(function () {
                    let optionValue = parseInt($(this).attr("value"));
                    if (isTaggable(optionValue)) {
                        enableTags();
                    } else {
                        disableTags();
                    }
                });
            }).change();

            function isTaggable(value) {
                return !($.inArray(value, [{{ \Gamify\Enums\BadgeActuators::triggeredByQuestionsList() }}]) === -1);
            }

            function enableTags() {
                $('#tags-selector').show();
                $('#tags').prop('disabled', false)
            }

            function disableTags() {
                $('#tags-selector').hide();
                $('#tags').prop('disabled', true)
            }

        });
    </script>
@endpush
