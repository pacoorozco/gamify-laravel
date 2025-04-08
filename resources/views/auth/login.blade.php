@extends('layouts.auth')

{{-- Web site Title --}}
@section('title')
    {{ __('auth.login') }}
@endsection

{{-- Content --}}
@section('content')
    <!-- start: LOGIN BOX -->
    <p class="login-box-msg">{{ __('auth.sign_title') }}</p>

    @include('auth._social_login')

    <a href="#" class="btn btn-block btn-flat btn-default" role="button" id="email-login-btn">
        <i class="bi bi-envelope-fill"></i> {{ __('social_login.e-mail') }}
    </a>

    <div id="email-login" class="d-none">

        <x-forms.form method="post" :action="route('login')">

            <div class="form-group mb-3">
                <div class="input-group">
                    <input id="email" name="email"
                           type="email"
                           placeholder="{{ __('auth.email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           autofocus="autofocus"
                           required
                           autocomplete="username"
                           aria-describedby="validationEmailFeedback"
                    />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="bi bi-envelope-fill"></span>
                        </div>
                    </div>
                    @error('email')
                    <span id="validationEmailFeedback" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="input-group">
                    <input id="password" name="password"
                           type="password"
                           placeholder="{{ __('auth.password') }}"
                           class="form-control"
                           required
                           autocomplete="password"
                    />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="bi bi-lock-fill"></span>
                        </div>
                    </div>
                </div>
            </div>

            <p class="text-right">
                <a href="{{ route('password.request') }}">{{ __('auth.forgot_password') }}</a>
            </p>

            <x-forms.checkbox name="remember" :label="__('auth.remember_me')" value="1" :checked="false"/>

            <x-forms.submit type="primary" :value="__('auth.login')" class="btn-block btn-flat" id="loginButton"/>

        </x-forms.form>
    </div>

    <p class="text-center mt-3">
        {{ __('auth.dont_have_account') }} <a href="{{ route('register') }}">{{ __('auth.create_account') }}</a>
    </p>

    <!-- end: LOGIN BOX -->
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#email-login-btn').click(function () {
                $("#email-login").removeClass("d-none");
                $("#email-login-btn").addClass("d-none");
            });
        });
    </script>
@endpush
