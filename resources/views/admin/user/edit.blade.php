@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ __('admin/user/title.user_update') }}
@endsection

{{-- Content Header --}}
@section('header')
    {{ __('admin/user/title.user_update') }}
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
        {{ __('admin/user/title.user_update') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    {{-- Create / Edit User Form --}}
    <x-forms.form method="put" :action="route('admin.users.update', $user)">

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    {{ $user->username }} {{ $user->present()->adminLabel }}
                </h2>
            </div>
            <div class="card-body">
                <div class="row">

                    <!-- right column -->
                    <div class="col-md-6">
                        <!-- username -->
                        <x-forms.input name="username" :label="__('admin/user/model.username')" :value="$user->username"
                                       :disabled="true"/>
                        <!-- ./ username -->

                        <!-- name -->
                        <x-forms.input name="name" :label="__('admin/user/model.name')" :value="$user->name"
                                       :required="true"/>
                        <!-- ./ name -->

                        <!-- Email -->
                        <x-forms.input name="email" type="email" :label="__('admin/user/model.email')"
                                       :value="$user->email" :required="true"/>
                        <!-- ./ email -->

                        <!-- role -->
                        <x-forms.select name='role'
                                        :label="__('admin/user/model.role')"
                                        :help="__('admin/user/messages.roles_help')"
                                        :options="\Gamify\Enums\Roles::options()"
                                        :required="Auth::user()->can('update-role', $user)"
                                        :disabled="Auth::user()->cannot('update-role', $user)"
                        />
                        <!-- ./ role -->

                    </div>
                    <!-- ./left column -->

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
                    <!-- ./right column -->

                </div>
            </div>

            <div class="card-footer">
                <!-- form actions -->
                <x-forms.submit type="primary" :value="__('button.update')"/>

                <a href="{{ route('admin.users.index') }}" class="btn btn-link" role="button">
                    {{ __('general.cancel') }}
                </a>
                <!-- ./ form actions -->
            </div>

        </div>
    </x-forms.form>

    @can('delete-user', $user)
        <!-- confirmation modal -->
        <x-modals.confirmation
            action="{{ route('admin.users.destroy', $user) }}"
            confirmationText="{{ $user->username }}"
            buttonText="{{ __('admin/user/messages.delete_confirmation_button') }}">

            <div class="alert alert-warning" role="alert">
                {{ __('admin/user/messages.delete_confirmation_warning', ['name' => $user->username]) }}
            </div>
        </x-modals.confirmation>
        <!-- ./ confirmation modal -->
    @endcan
@endsection
