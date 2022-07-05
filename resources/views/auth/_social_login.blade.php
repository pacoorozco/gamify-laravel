<!-- start: Social Login options -->
<div class="social-auth-links text-center">

    @if(config('services.facebook.client_id'))
        <a href="{{ route('social.login', ['provider' => 'facebook']) }}"
           class="btn btn-block btn-social btn-facebook btn-flat"><i
                class="fa fa-facebook"></i>{{ __('social_login.facebook') }}</a>
    @endif
    @if(config('services.twitter.client_id'))
        <a href="{{ route('social.login', ['provider' => 'github']) }}"
           class="btn btn-block btn-social btn-twitter btn-flat"><i
                class="fa fa-github"></i>{{ __('social_login.twitter') }}
        </a>
    @endif
    @if(config('services.github.client_id'))
        <a href="{{ route('social.login', ['provider' => 'github']) }}"
           class="btn btn-block btn-flat"><i class="fa fa-github"></i>{{ __('social_login.github') }}
        </a>
    @endif
    @if(config('services.okta.client_id'))
        <a href="{{ route('social.login', ['provider' => 'okta']) }}" class="btn btn-block btn-flat btn-primary"
           role="button">
            <i class="fa fa-circle-o"></i> {{ __('social_login.okta') }}
        </a>
    @endif

    @if(config('services.facebook.client_id') || config('services.twitter.client_id') || config('services.github.client_id') || config('services.okta.client_id'))
        <p class="text-center">- OR -</p>
    @endif

</div>
<!-- end: Social Login options -->
