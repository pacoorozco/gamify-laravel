@extends('layouts.login')

{{-- Web site Title --}}
@section('title')@lang('auth.login')@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/AdminLTE/plugins/iCheck/square/blue.css') }}">
@endpush

{{-- Content --}}
@section('content')
    <!-- start: LOGIN BOX -->
    <p class="login-box-msg">@lang('auth.sign_title')</p>

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
    <div class="row">
        <div class="col-xs-8">
            <div class="checkbox icheck">
                <label>
                    {!! Form::checkbox('remember', '1', false) !!}
                    @lang('auth.remember_me')
                </label>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
            {!! Form::submit(__('auth.login'), ['class' => 'btn btn-primary btn-block btn-flat', 'id' => 'loginButton']) !!}
        </div>
        <!-- /.col -->
    </div>
    {!! Form::close() !!}
    <a href="{{ route('password.request') }}">
        @lang('auth.forgot_password')
    </a><br>
    <a href="{{ route('register') }}" class="text-center">
        @lang('auth.create_account')
    </a>
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
        });
    </script>
@endpush
