@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/badge/title.badge_show'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/badge/title.badge_show') }}
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
        {{ __('admin/badge/title.badge_show') }}
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
                {{ $badge->present()->nameWithStatusBadge }}
            </h2>
        </div>
        <div class="box-body">

            <div class="row">
                <div class="col-md-6">

                    <!-- name -->
                    <dl>
                        <dt>
                            {{ __('admin/badge/model.name') }}
                        </dt>
                        <dd>
                            {{ $badge->name }}
                        </dd>
                    </dl>
                    <!-- ./ name -->

                    <!-- description -->
                    <dl>
                        <dt>
                            {{ __('admin/badge/model.description') }}
                        </dt>
                        <dd>
                            {{ $badge->description }}
                        </dd>
                    </dl>
                    <!-- ./ description -->

                    <!-- required_repetitions -->
                    <dl>
                        <dt>
                            {{ __('admin/badge/model.required_repetitions') }}
                        </dt>
                        <dd>
                            {{ $badge->required_repetitions }}
                        </dd>
                    </dl>
                    <!-- ./ required_repetitions -->

                    <!-- actuators -->
                    <dl>
                        <dt>
                            {{ __('admin/badge/model.actuators') }}
                        </dt>
                        <dd>
                            {{ $badge->actuators->description }}
                        </dd>
                    </dl>
                    <!-- ./ actuators -->

                    @if(\Gamify\Enums\BadgeActuators::canBeTagged($badge->actuators))
                    <dl>
                        <!-- tags -->
                        <dt>{{ __('admin/badge/model.tags') }}</dt>
                        <dd>
                            {{ $badge->present()->tags() }}
                        </dd>
                        <!-- ./ tags -->
                    </dl>
                    @endif

                    <!-- Activation Status -->
                    <dl>
                        <dt>
                            {{ __('admin/badge/model.active') }}
                        </dt>
                        <dd>
                            {{ $badge->present()->status() }}
                        </dd>
                    </dl>
                    <!-- ./ activation status -->

                </div>
                <div class="col-md-6">

                    <!-- image -->
                    <dl>
                        <dt>
                            {{ __('admin/badge/model.image') }}
                        </dt>
                        <dd>
                            {{ $badge->present()->imageThumbnail() }}
                        </dd>
                    </dl>
                    <!-- ./ image -->

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
            </div>

        </div>
        <div class="box-footer">
            <a href="{{ route('admin.badges.edit', $badge) }}">
                <button type="button" class="btn btn-primary">
                    {{ __('general.edit') }}
                </button>
            </a>

            <a href="{{ route('admin.badges.index') }}" class="btn btn-link" role="button">
                {{ __('general.back') }}
            </a>
        </div>
    </div>

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
