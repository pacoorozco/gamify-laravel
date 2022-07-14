@extends('layouts.login')

{{-- Web site Title --}}
@section('title')
    {{ __('auth.register') }}
@endsection

@section('content')
    <p class="login-box-msg">{{ __('auth.create_account') }}</p>

    @include('auth._social_login')

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group has-feedback{{ $errors->has('username') ? ' has-error' : '' }}">
            <input type="text" class="form-control" placeholder="{{ __('admin/user/model.username') }}"
                   name="username" value="{{ old('username') }}" required="required">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>

            <span class="help-block">{{ $errors->first('username', ':message') }}</span>
        </div>

        <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
            <input class="form-control" placeholder="{{ __('admin/user/model.email') }}"
                   name="email" type="text" value="{{ old('email') }}" required="required">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

            <span class="help-block">{{ $errors->first('email', ':message') }}</span>
        </div>

        <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
            <input class="form-control" placeholder="{{ __('admin/user/model.password') }}" type="password"
                   name="password" required="required">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>

            <ul class="help-block">
                @foreach($errors->get('password') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="{{ __('admin/user/model.password_confirmation') }}"
                   name="password_confirmation" required="required">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        </div>

        <div class="checkbox{{ $errors->has('terms') ? ' has-error' : '' }}">
            <label for="terms">
                <input name="terms" type="checkbox" @checked(old('terms'))> I agree to the <a href="#">terms</a>
            </label>
            <span class="help-block">{{ $errors->first('terms', ':message') }}</span>
        </div>

        <input class="btn btn-primary btn-block btn-flat" type="submit" value="{{ __('auth.register') }}">
    </form>

    <p></p>
    <p class="text-center">
        <a href="{{ route('login') }}" class="text-center">{{ __('auth.already_signed_in') }}</a>
    </p>
@endsection
