@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/user/title.user_show'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/user/title.user_show') }}
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.home') }}">
            {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.users.index') }}">
            {{ __('admin/site.users') }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        {{ __('admin/user/title.user_show') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                {{ $user->username }} {{ $user->present()->adminLabel() }}
            </h2>
        </div>
        <div class="card-body">
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

                    <!-- level -->
                    <dl class="row">
                        <dt class="col col-md-2">{{ __('user/profile.level') }}:</dt>
                        <dd class="col">{{$user->level}}</dd>
                    </dl>
                    <!-- ./ level -->

                    <!-- badges -->
                    <dl class="row">
                        <dt class="col col-md-2">{{ __('user/profile.badges') }}:</dt>
                        <dd class="col">{{ $user->unlockedBadgesCount() }}</dd>
                    </dl>
                    <!-- ./ badges -->

                    <!-- experience -->
                    <dl class="row">
                        <dt class="col col-md-2">{{ __('user/profile.experience') }}:</dt>
                        <dd class="col">{{ $user->experience }}</dd>
                    </dl>
                    <!-- ./ experience -->

                    <!-- created_at -->
                    <dl class="row">
                        <dt class="col col-md-2">{{ __('user/profile.user_since') }}:</dt>
                        <dd class="col">{{ $user->present()->createdAt }}</dd>
                    </dl>
                    <!-- ./ created_at -->

                    <!-- danger zone -->
                    @can('delete-user', $user)
                        <div class="card">
                            <div class="card-header bg-danger">
                                <strong> {{ __('admin/user/messages.danger_zone_section') }}</strong>
                            </div>
                            <div class="card-body">
                                <p><strong>{{ __('admin/user/messages.delete_button') }}</strong></p>
                                <p>{{ __('admin/user/messages.delete_help') }}</p>

                                <div class="text-center">
                                    <button type="button" class="btn btn-danger"
                                            data-toggle="modal"
                                            data-target="#confirmationModal">
                                        {{ __('admin/user/messages.delete_button') }}
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

        <div class="card-footer">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary" role="button">
                    {{ __('general.edit') }}
            </a>

            <a href="{{ route('admin.users.index') }}" class="btn btn-link" role="button">
                {{ __('general.cancel') }}
            </a>
        </div>
    </div>

    @can('delete-user', $user)
        <!-- confirmation modal -->
        <x-modals.confirmation
            :action="route('admin.users.destroy', $user)"
            :confirmationText="$user->username"
            :buttonText="__('admin/user/messages.delete_confirmation_button')">

            <div class="alert alert-warning" role="alert">
                {!! __('admin/user/messages.delete_confirmation_warning', ['name' => $user->username]) !!}
            </div>
        </x-modals.confirmation>
        <!-- ./ confirmation modal -->
    @endcan
@endsection
