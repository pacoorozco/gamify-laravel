@extends('layouts.master')

{{-- Web site Title --}}
@section('title', __('auth.change_password'))

{{-- Content Header --}}
@section('header', __('auth.change_password'))

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">
            {{ __('site.home') }}
        </a>
    </li>

    <li class="breadcrumb-item">
        <a href="{{ route('account.index') }}">
            {{ __('site.my_profile') }}
        </a>
    </li>

    <li class="breadcrumb-item active">
        {{ __('user/profile.change_password') }}
    </li>
@endsection

@section('content')
    <!-- panel -->
    <div class="card">
        <div class="card-body">

            <form method="post" action="{{ route('account.password.update') }}">
                @csrf

                <!-- current password -->
                <div class="form-group row {{ $errors->has('current-password') ? ' has-error' : '' }}">
                    <label for="current-password" class="col-md-4 col-form-label">
                        {{ __('user/profile.current_password') }}
                    </label>

                    <div class="col-md-6">
                        <input id="current-password" type="password" class="form-control @error('current-password') is-invalid @enderror"
                               name="current-password" required>

                        @error('current-password')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- /.current password -->

                <!-- new password -->
                <div class="form-group row {{ $errors->has('new-password') ? ' has-error' : '' }}">
                    <label for="new-password" class="col-md-4 col-form-label">
                        {{ __('user/profile.new_password') }}
                    </label>

                    <div class="col-md-6">
                        <input id="new-password" type="password" class="form-control @error('new-password') is-invalid @enderror" name="new-password"
                               required>

                        @error('new-password')
                            <ul class="error invalid-feedback">
                                @foreach($errors->get('new-password') as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @enderror
                    </div>
                </div>
                <!-- /. new password -->

                <!-- new password confirmation -->
                <div class="form-group row">
                    <label for="new-password-confirm" class="col-md-4 col-form-label">
                        {{ __('user/profile.new_password_confirm') }}
                    </label>

                    <div class="col-md-6">
                        <input id="new-password-confirm" type="password" class="form-control @error('new-password') is-invalid @enderror"
                               name="new-password_confirmation" required>
                    </div>
                </div>
                <!-- new password confirmation -->

                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('button.update') }} <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
    <!-- ./ panel -->
@endsection
