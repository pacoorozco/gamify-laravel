@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/level/title.level_update'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/level/title.level_update') }}
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li>
        <a href="{{ route('admin.levels.index') }}">
            {{ __('admin/site.levels') }}
        </a>
    </li>
    <li class="active">
        {{ __('admin/level/title.level_edit') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    <x-forms.form method="put" :action="route('admin.levels.update', $level)" hasFiles>

    <div class="box box-solid">
        <div class="box-header with-border">
            <h2 class="box-title">
                {{ $level->present()->nameWithStatusBadge() }}
            </h2>
        </div>
        <div class="box-body">
            <div class="row">

                <!-- right column -->
                <div class="col-md-6">

                    <!-- name -->
                    <x-forms.input name="name" :label="__('admin/level/model.name')" value="{{ $level->name }}" :required="true"/>
                    <!-- ./ name -->

                    <!-- required_points -->
                    <x-forms.input type="number" name="required_points"
                                   :label="__('admin/level/model.required_points')"
                                   min="0"
                                   value="{{ $level->required_points }}"
                                   :required="true"/>
                    <!-- ./ required_points -->

                    <!-- activation status -->
                    <x-forms.select name='active'
                                    :label="__('admin/level/model.active')"
                                    :options="['1' => __('general.yes'), '0' => __('general.no')]"
                                    selectedKey="{{ $level->active ? '1' : '0' }}"
                                    :required="true"/>
                    <!-- ./ activation status -->

                </div>
                <!-- ./left column -->

                <!-- right column -->
                <div class="col-md-6">

                    <!-- image -->
                    <x-forms.input-group :hasError="$errors->has('image')">
                        <x-forms.label for="image" :value="__('admin/level/model.image')"/>
                        <p class="text-muted">{{ __('admin/level/model.image_help') }}</p>
                        <div class="controls">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                     style="width: 150px; height: 150px;">
                                    {{ $level->present()->imageTag() }}
                                </div>
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
                                    <a href="#" class="btn fileinput-exists btn-default" data-dismiss="fileinput" role="button">
                                        <i class="fa fa-times"></i> {{ __('button.delete_image') }}
                                    </a>
                                </p>
                            </div>
                        </div>
                        <span class="help-block">{{ $errors->first('image', ':message') }}</span>
                    </x-forms.input-group>
                    <!-- ./ image -->

                    <!-- danger zone -->
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <strong>@lang('admin/level/messages.danger_zone_section')</strong>
                        </div>
                        <div class="panel-body">
                            <p><strong>@lang('admin/level/messages.delete_button')</strong></p>
                            <p>@lang('admin/level/messages.delete_help')</p>

                            <div class="text-center">
                                <button type="button" class="btn btn-danger"
                                        data-toggle="modal"
                                        data-target="#confirmationModal">
                                    @lang('admin/level/messages.delete_button')
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
            <!-- Form Actions -->
            <x-forms.submit type="success" :value="__('button.save')"/>

            <a href="{{ route('admin.levels.index') }}" class="btn btn-link" role="button">
                {{ __('general.back') }}
            </a>
            <!-- ./ form actions -->
        </div>

    </div>
    </x-forms.form>>

    <!-- confirmation modal -->
    <x-modals.confirmation
        action="{{ route('admin.levels.destroy', $level) }}"
        confirmationText="{{ $level->name }}"
        buttonText="{{ __('admin/level/messages.delete_confirmation_button') }}">

        <div class="alert alert-warning" role="alert">
            @lang('admin/level/messages.delete_confirmation_warning', ['name' => $level->name])
        </div>
    </x-modals.confirmation>
    <!-- ./ confirmation modal -->
@endsection

{{-- Styles --}}
@push('styles')
    <!-- File Input -->
    <link rel="stylesheet" href="{{ asset('vendor/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
@endpush

{{-- Scripts --}}
@push('scripts')
    <!-- File Input -->
    <script type="text/javascript" src="{{ asset('vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
@endpush


