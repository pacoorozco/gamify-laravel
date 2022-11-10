<ul class="nav navbar-nav">

    @auth
    <li class="{{ request()->is('/') ? 'active' : '' }}">
        <a href="{{ route('home') }}">
            {{ __('site.home') }}
            @if( request()->is('/'))
                <span class="sr-only">(current)</span>
            @endif
        </a>
    </li>

    <li class="{{ request()->is('questions*') ? 'active' : '' }}">
        <a href="{{ route('questions.index') }}">
            {{ __('site.play') }}
            @if( request()->is('questions*'))
                <span class="sr-only">(current)</span>
            @endif
        </a>
    </li>
    @endauth

    <li class="{{ request()->is('leaderboard') ? 'active' : '' }}">
        <a href="{{ route('leaderboard') }}">
            {{ __('site.leaderboard') }}
            @if( request()->is('leaderboard'))
                <span class="sr-only">(current)</span>
            @endif
        </a>
    </li>

</ul>
