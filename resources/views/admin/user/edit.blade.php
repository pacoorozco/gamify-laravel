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
        {{ __('admin/user/title.user_update') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    {{-- Create / Edit User Form --}}
    {!! Form::model($user, ['route' => ['admin.users.update', $user], 'method' => 'put']) !!}

    <div class="box box-solid">
        <div class="box-header with-border">
            <h2 class="box-title">
                {{ $user->username }} {{ $user->present()->adminLabel }}
            </h2>
        </div>
        <div class="box-body">
            <div class="row">

                <!-- right column -->
                <div class="col-md-6">
                    <!-- username -->
                    <div class="form-group">
                        {!! Form::label('username', __('admin/user/model.username'), ['class' => 'control-label']) !!}
                        <div class="controls">
                            {!! Form::text('username', $user->username, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                        </div>
                    </div>
                    <!-- ./ username -->

                    <!-- name -->
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('name', __('admin/user/model.name'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                    <!-- ./ name -->

                    <!-- Email -->
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::label('email', __('admin/user/model.email'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                        </div>
                    </div>
                    <!-- ./ email -->

                    <!-- role -->
                    <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">
                        {!! Form::label('role', __('admin/user/model.role'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            @cannot('update-role', $user)
                                {!! Form::select('role', \Gamify\Enums\Roles::asSelectArray(), $user->role, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                                {!! Form::hidden('role', $user->role) !!}
                            @else
                                {!! Form::select('role', \Gamify\Enums\Roles::asSelectArray(), \Gamify\Enums\Roles::Player, ['class' => 'form-control', 'required' => 'required']) !!}
                                <p class="text-muted">{{ __('admin/user/messages.roles_help') }}</p>
                            @endcannot
                        </div>
                    </div>
                    <!-- ./ role -->

                </div>
                <!-- ./left column -->

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
                <!-- ./right column -->

            </div>
        </div>

        <div class="box-footer">
            <!-- form actions -->
            {!! Form::button(__('button.update'), ['type' => 'submit', 'class' => 'btn btn-success']) !!}
            <a href="{{ route('admin.users.index') }}" class="btn btn-link" role="button">
                {{ __('general.back') }}
            </a>
            <!-- ./ form actions -->
        </div>

    </div>
    {!! Form::close() !!}

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
