@extends('layouts.login')

{{-- Web site Title --}}
@section('title')
    {{ __('auth.email_verification') }}
@endsection

{{-- Content --}}
@section('content')
    <p class="login-box-msg">{{ __('auth.email_verification_instructions') }}</p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf

        <input class="btn btn-primary btn-block btn-flat" type="submit"
               value="{{ __('auth.email_verification_action') }}">
    </form>

    <form method="post" action="{{ route('logout') }}">
        @csrf
        <input class="btn btn-default btn-flat" type="submit" value="{{ __('auth.logout') }}">
    </form>
@endsection
