<!-- start: Social Login options -->
<div class="social-auth-links text-center">

    {{-- facebook --}}
    @if(config('services.facebook.client_id'))
        <a href="{{ route('social.login', ['provider' => 'facebook']) }}"
           class="btn btn-block btn-flat btn-primary">
            <i class="bi bi-facebook mr-2"></i> {{ __('social_login.facebook') }}
        </a>
    @endif

    {{-- x-twitter --}}
    @if(config('services.twitter.client_id'))
        <a href="{{ route('social.login', ['provider' => 'twitter']) }}"
           class="btn btn-block btn-flat btn-info">
            <i class="mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="navbar-nav-svg" viewBox="0 0 1200 1227" role="img"><title>X</title><path fill="currentColor" d="M714.163 519.284 1160.89 0h-105.86L667.137 450.887 357.328 0H0l468.492 681.821L0 1226.37h105.866l409.625-476.152 327.181 476.152H1200L714.137 519.284h.026ZM569.165 687.828l-47.468-67.894-377.686-540.24h162.604l304.797 435.991 47.468 67.894 396.2 566.721H892.476L569.165 687.854v-.026Z"></path></svg>
            </i>
            {{ __('social_login.x-twitter') }}
{{--            <i class="fab fa-twitter mr-2"></i> {{ __('social_login.x-twitter') }}--}}
        </a>
    @endif

    {{-- github --}}
    @if(config('services.github.client_id'))
        <a href="{{ route('social.login', ['provider' => 'github']) }}"
           class="btn btn-block btn-flat btn-dark">
            <i class="bi bi-github mr-2"></i> {{ __('social_login.github') }}
        </a>
    @endif

    {{-- okta --}}
    @if(config('services.okta.client_id'))
        <a href="{{ route('social.login', ['provider' => 'okta']) }}"
           class="btn btn-block btn-flat btn-secondary">
            <i class="bi bi-opencollective mr-2"></i> {{ __('social_login.okta') }}
        </a>
    @endif

    @if(config('services.facebook.client_id') || config('services.twitter.client_id') || config('services.github.client_id') || config('services.okta.client_id'))
        <p class="text-center mt-3">- OR -</p>
    @endif

</div>
<!-- end: Social Login options -->
