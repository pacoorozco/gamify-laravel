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

        {!! Form::open(['route' => 'login']) !!}
        <div class="form-group has-feedback">
            {!! Form::text('email', null, [
                        'class' => 'form-control',
                        'placeholder' => __('auth.email'),
                        'required' => 'required',
                        'autofocus' => 'autofocus',
                        ]) !!}
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            {!! Form::password('password', [
                        'class' => 'form-control password',
                        'placeholder' => __('auth.password'),
                        'required' => 'required',
                        ]) !!}
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        @if(Route::has('password.request'))
            <p class="text-right">
                <a href="{{ route('password.request') }}">{{ __('auth.forgot_password') }}</a>
            </p>
        @endif

        <div class="checkbox icheck">
            <label>
                {!! Form::checkbox('remember', '1', false) !!} {{ __('auth.remember_me') }}
            </label>
        </div>

        {!! Form::submit(__('auth.login'), ['class' => 'btn btn-primary btn-block btn-flat', 'id' => 'loginButton']) !!}
        {!! Form::close() !!}
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
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });

            $('#email-login-btn').click(function () {
                $("#email-login").removeClass("hidden");
                $("#email-login-btn").addClass("hidden");
            });
        });
    </script>
@endpush
