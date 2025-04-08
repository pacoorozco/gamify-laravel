@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/badge/title.create_a_new_badge'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/badge/title.create_a_new_badge') }}
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="bi bi-house-fill"></i> {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li>
        <a href="{{ route('admin.badges.index') }}">
            {{ __('admin/site.badges') }}
        </a>
    </li>
    <li class="active">
        {{ __('admin/badge/title.create_a_new_badge') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    {{-- Create Badge Form --}}
    <x-forms.form method="post" :action="route('admin.badges.store')" hasFiles>

        <div class="box box-solid">
            <div class="box-body">
                <div class="row">

                    <!-- right column -->
                    <div class="col-md-6">

                        <fieldset>
                            <!-- name -->
                            <x-forms.input name="name" :label="__('admin/badge/model.name')" :required="true"/>
                            <!-- ./ name -->

                            <!-- description -->
                            <x-forms.textarea name="description" :label="__('admin/badge/model.description')"
                                              :required="true"/>
                            <!-- ./ description -->
                        </fieldset>

                        <fieldset>
                            <!-- required_repetitions -->
                            <x-forms.input type="number" name="required_repetitions"
                                           :label="__('admin/badge/model.required_repetitions')"
                                           :help="__('admin/badge/model.required_repetitions_help')"
                                           min="1"
                                           :required="true"/>
                            <!-- ./ required_repetitions -->


                            <!-- actuators -->
                            <x-forms.select name='actuators'
                                            :label="__('admin/badge/model.actuators')"
                                            :help="__('admin/badge/model.actuators_help')"
                                            :options="\Gamify\Enums\BadgeActuators::options()"
                                            class="tags-actuators"
                                            :required="true"/>
                            <!-- ./ actuators -->

                            <!-- tags -->
                            <x-forms.select-tags name="tags"
                                                 :label="__('admin/badge/model.tags')"
                                                 :help="__('admin/badge/model.tags_help')"
                                                 :placeholder="__('admin/badge/model.tags_placeholder')"
                                                 :selected-tags="old('tags', [])"
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

                            <p class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new">
                                    <img src="{{ asset('images/missing_badge.png') }}" class="img-thumbnail"
                                         style="width: 150px; height: 150px;" alt="default image">
                                </div>
                                <div class="fileinput-preview fileinput-exists img-thumbnail"
                                     style="max-width: 150px; max-height: 150px;">
                                </div>

                                <!-- image buttons -->
                                <p>
                                                        <span class="btn btn-default btn-file">
                                                            <span class="fileinput-new">
                                                                <i class="bi bi-image"></i> {{ __('button.pick_image') }}
                                                            </span>
                                                            <span class="fileinput-exists">
                                                                <i class="bi bi-image"></i> {{ __('button.upload_image') }}
                                                            </span>
                                                            <input type="file" name="image">
                                                        </span>
                                    <a href="#" class="fileinput-exists btn btn-default" data-dismiss="fileinput"
                                       role="button">
                                        <i class="bi bi-trash"></i> {{ __('button.delete_image') }}
                                    </a>

                                </p>
                                <!-- ./image buttons -->

                            <span class="help-block">{{ $errors->first('image', ':message') }}</span>
                        </x-forms.input-group>
                        <!-- ./ image -->

                        <!-- status -->
                        <x-forms.select name='active'
                                        :label="__('admin/badge/model.active')"
                                        :options="['1' => __('general.yes'), '0' => __('general.no')]"
                                        :required="true"/>
                        <!-- ./status -->

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
