<!-- start: Social Login options -->
<div class="social-auth-links text-center">

    {{-- facebook --}}
    @if(config('services.facebook.client_id'))
        <a href="{{ route('social.login', ['provider' => 'facebook']) }}"
           class="btn btn-block btn-social btn-facebook btn-flat">
            <i class="fa fa-facebook"></i> {{ __('social_login.facebook') }}
        </a>
    @endif

    {{-- twitter --}}
    @if(config('services.twitter.client_id'))
        <a href="{{ route('social.login', ['provider' => 'twitter']) }}"
           class="btn btn-block btn-social btn-twitter btn-flat">
            <i class="fa fa-github"></i> {{ __('social_login.twitter') }}
        </a>
    @endif

    {{-- github --}}
    @if(config('services.github.client_id'))
        <a href="{{ route('social.login', ['provider' => 'github']) }}"
           class="btn btn-block btn-social btn-github btn-flat">
            <i class="fa fa-github"></i> {{ __('social_login.github') }}
        </a>
    @endif

    {{-- okta --}}
    @if(config('services.okta.client_id'))
        <a href="{{ route('social.login', ['provider' => 'okta']) }}"
           class="btn btn-block btn-social btn-openid btn-flat">
            <i class="fa fa-openid"></i> {{ __('social_login.okta') }}
        </a>
    @endif

    @if(config('services.facebook.client_id') || config('services.twitter.client_id') || config('services.github.client_id') || config('services.okta.client_id'))
        <p></p>
        <p class="text-center">- OR -</p>
    @endif

</div>
<!-- end: Social Login options -->
