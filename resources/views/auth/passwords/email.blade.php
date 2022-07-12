@extends('layouts.login')

{{-- Web site Title --}}
@section('title')
    {{ __('auth.forgot_password_title') }}
@endsection

{{-- Content --}}
@section('content')
    <p class="login-box-msg">{{ __('auth.forgot_password_instructions') }}</p>

    <form method="post" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group has-feedback">
            <input class="form-control" placeholder="{{ __('auth.email') }}" required="required" autofocus="autofocus"
                   name="email" type="text">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>

        <input class="btn btn-primary btn-block btn-flat" type="submit" value="{{ __('button.submit') }}">
    </form>
@endsection
