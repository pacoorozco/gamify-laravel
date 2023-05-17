@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/user/title.user_show'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/user/title.user_show') }}
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li>
        <a href="{{ route('admin.users.index') }}">
            {{ __('admin/site.users') }}
        </a>
    </li>
    <li class="active">
        {{ __('admin/user/title.user_show') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    <div class="box">
        <div class="box-header with-border">
            <h2 class="box-title">
                {{ $user->username }} {{ $user->present()->adminLabel() }}
            </h2>
        </div>
        <div class="box-body">
            <div class="row">

                <!-- left column -->
                <div class="col-md-6">

                    <!-- username -->
                    <dl>
                        <dt>
                            {{ __('admin/user/model.username') }}
                        </dt>
                        <dd>
                            {{ $user->username }}
                        </dd>
                    </dl>
                    <!-- ./ username -->

                    <!-- name -->
                    <dl>
                        <dt>
                            {{  __('admin/user/model.name') }}
                        </dt>
                        <dd>
                            {{ $user->name }}
                        </dd>
                    </dl>
                    <!-- ./ name -->

                    <!-- email -->
                    <dl>
                        <dt>
                            {{ __('admin/user/model.email') }}
                        </dt>
                        <dd>
                            {{ $user->email }}
                        </dd>
                    </dl>
                    <!-- ./ email -->

                    <!-- role -->
                    <dl>
                        <dt>
                            {{ __('admin/user/model.role') }}
                        </dt>
                        <dd>
                            {{ $user->present()->role() }}
                        </dd>
                    </dl>
                    <!-- ./ role -->

                </div>
                <!-- ./ left column -->

                <!-- right column -->
                <div class="col-md-6">

                    <dl class="dl-horizontal">

                        <!-- level -->
                        <dt>{{ __('user/profile.level') }}:</dt>
                        <dd>{{$user->level}}</dd>
                        <!-- ./ level -->

                        <!-- badges -->
                        <dt>{{ __('user/profile.badges') }}:</dt>
                        <dd>{{ $user->unlockedBadgesCount() }}</dd>
                        <!-- ./ badges -->

                        <!-- experience -->
                        <dt>{{ __('user/profile.experience') }}:</dt>
                        <dd>{{ $user->experience }}</dd>
                        <!-- ./ experience -->

                        <!-- created_at -->
                        <dt>{{ __('user/profile.user_since') }}:</dt>
                        <dd>{{ $user->present()->createdAt }}</dd>
                        <!-- ./ created_at -->

                    </dl>

                    <!-- danger zone -->
                    @can('delete-user', $user)
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <strong>@lang('admin/user/messages.danger_zone_section')</strong>
                            </div>
                            <div class="panel-body">
                                <p><strong>@lang('admin/user/messages.delete_button')</strong></p>
                                <p>@lang('admin/user/messages.delete_help')</p>

                                <div class="text-center">
                                    <button type="button" class="btn btn-danger"
                                            data-toggle="modal"
                                            data-target="#confirmationModal">
                                        @lang('admin/user/messages.delete_button')
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endcan
                    <!-- ./danger zone -->

                </div>
                <!-- ./ right column -->

            </div>
        </div>

        <div class="box-footer">
            <a href="{{ route('admin.users.edit', $user) }}">
                <button type="button" class="btn btn-primary">
                    {{ __('general.edit') }}
                </button>
            </a>

            <a href="{{ route('admin.users.index') }}" class="btn btn-link" role="button">
                {{ __('general.back') }}
            </a>
        </div>
    </div>

    @can('delete-user', $user)
        <!-- confirmation modal -->
        <x-modals.confirmation
            action="{{ route('admin.users.destroy', $user) }}"
            confirmationText="{{ $user->username }}"
            buttonText="{{ __('admin/user/messages.delete_confirmation_button') }}">

            <div class="alert alert-warning" role="alert">
                @lang('admin/user/messages.delete_confirmation_warning', ['name' => $user->username])
            </div>
        </x-modals.confirmation>
        <!-- ./ confirmation modal -->
    @endcan
@endsection
