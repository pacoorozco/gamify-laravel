@extends('layouts.login')

{{-- Web site Title --}}
@section('title')
    {{ __('passwords.forgot_password_title') }}
@endsection

{{-- Content --}}
@section('content')
    <p class="login-box-msg">{{ __('passwords.forgot_password_instructions') }}</p>

    <form method="post" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group has-feedback">
            <input class="form-control" placeholder="{{ __('auth.email') }}" required="required" autofocus="autofocus"
                   name="email" type="text" value="{{ old('email') }}">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>

        <input class="btn btn-primary btn-block btn-flat" type="submit" value="{{ __('passwords.forgot_password_action') }}">
    </form>
@endsection
