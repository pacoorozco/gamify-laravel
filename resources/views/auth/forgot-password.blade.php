@extends('layouts.auth')

{{-- Web site Title --}}
@section('title')
    {{ __('passwords.forgot_password_title') }}
@endsection

{{-- Content --}}
@section('content')
    <p class="login-box-msg">{{ __('passwords.forgot_password_instructions') }}</p>

    <x-forms.form method="post" :action="route('password.email')">

        <div class="form-group mb-3">
            <div class="input-group has-validation">
                <input class="form-control @error('email') is-invalid @enderror"
                       placeholder="{{ __('auth.email') }}" required="required"
                       autofocus="autofocus"
                       name="email" type="text" value="{{ old('email') }}"
                       aria-describedby="validationEmailFeedback">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="bi bi-envelope-open"></span>
                    </div>
                </div>
                @error('email')
                <span id="validationEmailFeedback" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <input class="btn btn-primary btn-block btn-flat" type="submit"
               value="{{ __('passwords.forgot_password_action') }}">
    </x-forms.form>
@endsection
