@extends('layouts.master')

{{-- Web site Title --}}
@section('title', __('auth.change_password'))

{{-- Content Header --}}
@section('header', __('auth.change_password'))

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('home') }}">
            <i class="fa fa-dashboard"></i> {{ __('site.home') }}
        </a>
    </li>

    <li>
        <a href="{{ route('account.index') }}">
            {{ __('site.my_profile') }}
        </a>
    </li>

    <li class="active">
        {{ __('user/profile.change_password') }}
    </li>
@endsection

@section('content')
    <!-- panel -->
    <div class="panel panel-default">
        <div class="panel-body">

            <form class="form-horizontal" method="post" action="{{ route('account.password.update') }}">
                @csrf

                <!-- current password -->
                <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                    <label for="current-password" class="col-md-4 control-label">
                        {{ __('user/profile.current_password') }}
                    </label>

                    <div class="col-md-6">
                        <input id="current-password" type="password" class="form-control"
                               name="current-password" required>

                        @error('current-password')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- /.current password -->

                <!-- new password -->
                <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                    <label for="new-password" class="col-md-4 control-label">
                        {{ __('user/profile.new_password') }}
                    </label>

                    <div class="col-md-6">
                        <input id="new-password" type="password" class="form-control" name="new-password"
                               required>

                        @error('new-password')
                            <ul class="help-block">
                                @foreach($errors->get('new-password') as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @enderror
                    </div>
                </div>
                <!-- /. new password -->

                <!-- new password confirmation -->
                <div class="form-group">
                    <label for="new-password-confirm" class="col-md-4 control-label">
                        {{ __('user/profile.new_password_confirm') }}
                    </label>

                    <div class="col-md-6">
                        <input id="new-password-confirm" type="password" class="form-control"
                               name="new-password_confirmation" required>
                    </div>
                </div>
                <!-- new password confirmation -->

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('button.update') }} <i class="fa fa-pencil-square-o"></i>
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
    <!-- ./ panel -->
@endsection
