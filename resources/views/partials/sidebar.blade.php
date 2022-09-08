<ul class="nav navbar-nav">

    <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}">
            {{ __('site.home') }}
            @if( request()->is('dashboard'))
                <span class="sr-only">(current)</span>
            @endif
        </a>
    </li>

    @auth
    <li class="{{ request()->is('questions*') ? 'active' : '' }}">
        <a href="{{ route('questions.index') }}">
            {{ __('site.play') }}
            @if (Auth::user()->pendingQuestionsCount())
                <span class="label label-danger">{{ Auth::user()->pendingQuestionsCount() }}</span>
            @endif
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
