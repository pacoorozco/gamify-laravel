@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/badge/title.create_a_new_badge'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/badge/title.create_a_new_badge') }}
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.home') }}">
            {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.badges.index') }}">
            {{ __('admin/site.badges') }}
        </a>
    </li>
    <li class="breadcrumb-item active">
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

        <div class="card">
            <div class="card-body">
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
                                                 :selected-tags="old('tags', [])"/>
                            <!-- ./ tags -->
                        </fieldset>

                    </div>
                    <!-- ./left column -->

                    <!-- right column -->
                    <div class="col-md-6">

                        <!-- image -->
                        <x-forms.input-image name="image"
                                         :label="__('admin/badge/model.image')"
                                         :help="__('admin/badge/model.image_help')"
                                         :value="old('image', asset('images/missing_badge.png'))"/>
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

            <div class="card-footer">
                <!-- form actions -->
                <x-forms.submit type="primary" :value="__('general.create')"/>

                <a href="{{ route('admin.badges.index') }}" class="btn btn-link" role="button">
                    {{ __('general.back') }}
                </a>
                <!-- ./ form actions -->
            </div>

        </div>

    </x-forms.form>

@endsection

{{-- Scripts --}}
@push('scripts')
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
