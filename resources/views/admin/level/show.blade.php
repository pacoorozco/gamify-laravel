@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/level/title.level_show'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/level/title.level_show') }}
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
        {{ __('admin/level/title.level_show') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    <div class="box box-solid">
        <div class="box-header with-border">
            <h2 class="box-title">
                {{ $level->present()->nameWithStatusBadge() }}
            </h2>
        </div>
        <div class="box-body">

            <div class="row">
                <div class="col-md-6">

                    <!-- name -->
                    <dl>
                        <dt>
                            {{ __('admin/level/model.name') }}
                        </dt>
                        <dd>
                            {{ $level->name }}
                        </dd>
                    </dl>
                    <!-- ./ name -->

                    <!-- required_points -->
                    <dl>
                        <dt>
                            {{ __('admin/level/model.required_points') }}
                        </dt>
                        <dd>
                            {{ $level->required_points }}
                        </dd>
                    </dl>
                    <!-- ./ required_points -->

                    <!-- Activation Status -->
                    <dl>
                        <dt>
                            {{ __('admin/level/model.active') }}
                        </dt>
                        <dd>
                            {{ $level->present()->status() }}
                        </dd>
                    </dl>
                    <!-- ./ activation status -->

                </div>
                <div class="col-md-6">

                    <!-- image -->
                    <dl>
                        <dt>
                            {{ __('admin/level/model.image') }}
                        </dt>
                        <dd>
                            {{ $level->present()->imageThumbnail() }}
                        </dd>
                    </dl>
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
            </div>

        </div>
        <div class="box-footer">
            <a href="{{ route('admin.levels.edit', $level) }}">
                <button type="button" class="btn btn-primary">
                    {{ __('general.edit') }}
                </button>
            </a>

            <a href="{{ route('admin.levels.index') }}" class="btn btn-link" role="button">
                {{ __('general.back') }}
            </a>
        </div>
    </div>

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
