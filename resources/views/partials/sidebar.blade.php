<ul class="navbar-nav">

    @auth
    <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
        <a href="{{ route('home') }}" class="nav-link">
            {{ __('site.home') }}
            @if( request()->is('/'))
                <span class="sr-only">(current)</span>
            @endif
        </a>
    </li>

    <li class="nav-item {{ request()->is('questions*') ? 'active' : '' }}">
        <a href="{{ route('questions.index') }}" class="nav-link">
            {{ __('site.play') }}
            @if( request()->is('questions*'))
                <span class="sr-only">(current)</span>
            @endif
        </a>
    </li>
    @endauth

    <li class="nav-item {{ request()->is('leaderboard') ? 'active' : '' }}">
        <a href="{{ route('leaderboard') }}" class="nav-link">
            {{ __('site.leaderboard') }}
            @if( request()->is('leaderboard'))
                <span class="sr-only">(current)</span>
            @endif
        </a>
    </li>

</ul>
