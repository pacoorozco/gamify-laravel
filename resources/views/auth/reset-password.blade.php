@extends('layouts.login')

{{-- Web site Title --}}
@section('title')
    {{ __('passwords.reset_password_action') }}
@endsection

{{-- Content --}}
@section('content')
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-group has-feedback">
            <input class="form-control" placeholder="{{ __('auth.email') }}" required="required"
                   name="email" type="text" value="{{ old('email', $request->input('email')) }}">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control password" placeholder="{{ __('passwords.new_password') }}"
                       required="required" name="password" autofocus="autofocus">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                @if ($errors->has('password'))
                    <ul class="help-block">
                        @foreach($errors->get('password') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
        </div>

        <div class="form-group has-feedback">
            <input type="password" class="form-control password" placeholder="{{ __('passwords.new_password_confirmation') }}"
                   required="required" name="password_confirmation">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <input class="btn btn-primary btn-block btn-flat" type="submit" value="{{ __('passwords.reset_password_action') }}">
    </form>
@endsection
