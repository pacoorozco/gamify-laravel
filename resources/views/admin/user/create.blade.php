@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ __('admin/user/title.create_a_new_user') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    {{ __('admin/user/title.create_a_new_user') }}
    <small>add a new user</small>
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
        {{ __('admin/user/title.create_a_new_user') }}
    </li>
@endsection


{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    {{-- Create / Edit User Form --}}
    {!! Form::open(['route' => ['admin.users.store'], 'method' => 'post']) !!}

    <div class="box box-solid">
        <div class="box-body">
            <div class="row">

                <!-- right column -->
                <div class="col-md-6">
                    <!-- username -->
                    <div class="form-group">
                        {!! Form::label('username', __('admin/user/model.username'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::text('username', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <span class="help-block">{{ $errors->first('username', ':message') }}</span>
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

                </div>
                <!-- ./left column -->

                <!-- right column -->
                <div class="col-md-6">

                    <!-- role -->
                    <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">
                        {!! Form::label('role', __('admin/user/model.role'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::select('role', \Gamify\Enums\Roles::asSelectArray(), \Gamify\Enums\Roles::Player, ['class' => 'form-control', 'required' => 'required']) !!}
                            <p class="text-muted">{{ __('admin/user/messages.roles_help') }}</p>
                            <span class="help-block">{{ $errors->first('role', ':message') }}</span>
                        </div>
                    </div>
                    <!-- ./ role -->

                </div>
                <!-- ./right column -->

            </div>
        </div>

        <div class="box-footer">
            <!-- form actions -->
            {!! Form::button(__('button.save'), ['type' => 'submit', 'class' => 'btn btn-success']) !!}
            <a href="{{ route('admin.users.index') }}" class="btn btn-link" role="button">
                {{ __('general.back') }}
            </a>
            <!-- ./ form actions -->
        </div>

    </div>
    {!! Form::close() !!}

@endsection
