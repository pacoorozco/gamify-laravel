@extends('layouts.login')

{{-- Web site Title --}}
@section('title'){{ __('auth.login') }}@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/AdminLTE/plugins/iCheck/square/blue.css') }}">
@endpush

{{-- Content --}}
@section('content')
    <!-- start: LOGIN BOX -->
    <p class="login-box-msg">{{ __('auth.sign_title') }}</p>

    @include('auth._social_login')

    <a href="#" class="btn btn-block btn-flat btn-default" role="button" id="email-login-btn">
        <i class="fa fa-envelope"></i> {{ __('social_login.e-mail') }}
    </a>

    <div id="email-login" class="hidden">

        <x-forms.form method="post" :action="route('login')">

        <div class="form-group has-feedback">
            <x-forms.input name="email"
                           :placeholder="__('auth.email')"
                           autofocus="autofocus"
                           :required="true"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <x-forms.input name="password"
                           type="password"
                           :placeholder="__('auth.password')"
                           :required="true"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        @if(Route::has('password.request'))
            <p class="text-right">
                <a href="{{ route('password.request') }}">{{ __('auth.forgot_password') }}</a>
            </p>
        @endif

            <x-forms.checkbox name="remember" :label="__('auth.remember_me')" value="1" :checked="false" class="icheck"/>

            <x-forms.submit type="primary" :value="__('auth.login')" class="btn-block btn-flat" id="loginButton"/>

        </x-forms.form>
    </div>

    <p></p>
    @if(Route::has('register'))
        <p class="text-center">
            {{ __('auth.dont_have_account') }} <a href="{{ route('register') }}">{{ __('auth.create_account') }}</a>
        </p>
    @endif

    <!-- end: LOGIN BOX -->
@endsection

@push('scripts')
    <script src="{{ asset('vendor/AdminLTE/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                increaseArea: '20%'
            });

            $('#email-login-btn').click(function () {
                $("#email-login").removeClass("hidden");
                $("#email-login-btn").addClass("hidden");
            });
        });
    </script>
@endpush
