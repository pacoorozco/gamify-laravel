@extends('layouts.auth')

{{-- Web site Title --}}
@section('title')
    {{ __('auth.email_verification') }}
@endsection

{{-- Content --}}
@section('content')
    @if (session('success') == 'verification-link-sent')
        <p class="login-box-msg">{{ __('auth.email_verification_instructions') }}</p>
    @endif

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
