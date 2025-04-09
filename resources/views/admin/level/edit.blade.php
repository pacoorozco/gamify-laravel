@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/level/title.level_update'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/level/title.level_update') }}
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.home') }}">
            <i class="bi bi-house-fill"></i> {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.levels.index') }}">
            {{ __('admin/site.levels') }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        {{ __('admin/level/title.level_edit') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    <x-forms.form method="put" :action="route('admin.levels.update', $level)" hasFiles>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                {{ $level->present()->nameWithStatusBadge() }}
            </h2>
        </div>
        <div class="card-body">
            <div class="row">

                <!-- right column -->
                <div class="col-md-6">

                    <!-- name -->
                    <x-forms.input name="name" :label="__('admin/level/model.name')" :value="$level->name" :required="true"/>
                    <!-- ./ name -->

                    <!-- required_points -->
                    <x-forms.input type="number" name="required_points"
                                   :label="__('admin/level/model.required_points')"
                                   min="0"
                                   :value="$level->required_points"
                                   :required="true"/>
                    <!-- ./ required_points -->

                    <!-- activation status -->
                    <x-forms.select name='active'
                                    :label="__('admin/level/model.active')"
                                    :options="['1' => __('general.yes'), '0' => __('general.no')]"
                                    :selectedKey="$level->active ? '1' : '0'"
                                    :required="true"/>
                    <!-- ./ activation status -->

                </div>
                <!-- ./left column -->

                <!-- right column -->
                <div class="col-md-6">

                    <!-- image -->
                    <x-forms.input-image name="image"
                                         :label="__('admin/level/model.image')"
                                         :help="__('admin/badge/model.image_help')"
                                         :value="old('image', $level->getFirstMediaUrl('image', 'detail'))"/>
                    <!-- ./ image -->

                    <!-- danger zone -->
                    <div class="card">
                        <div class="card-header bg-danger">
                            <strong>{{ __('admin/level/messages.danger_zone_section') }}</strong>
                        </div>
                        <div class="card-body">
                            <p><strong>{{ __('admin/level/messages.delete_button') }}</strong></p>
                            <p>{!! __('admin/level/messages.delete_help') !!}</p>

                            <div class="text-center">
                                <button type="button" class="btn btn-danger"
                                        data-toggle="modal"
                                        data-target="#confirmationModal">
                                    {{ __('admin/level/messages.delete_button') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- ./danger zone -->

                </div>
                <!-- ./right column -->

            </div>
        </div>

        <div class="card-footer">
            <!-- Form Actions -->
            <x-forms.submit type="primary" :value="__('general.update')"/>

            <a href="{{ route('admin.levels.index') }}" class="btn btn-link" role="button">
                {{ __('general.cancel') }}
            </a>
            <!-- ./ form actions -->
        </div>

    </div>
    </x-forms.form>

    <!-- confirmation modal -->
    <x-modals.confirmation
        :action="route('admin.levels.destroy', $level)"
        :confirmationText="$level->name"
        :buttonText="__('admin/level/messages.delete_confirmation_button')">

        <div class="alert alert-warning" role="alert">
            {!! __('admin/level/messages.delete_confirmation_warning', ['name' => $level->name]) !!}
        </div>
    </x-modals.confirmation>
    <!-- ./ confirmation modal -->
@endsection
