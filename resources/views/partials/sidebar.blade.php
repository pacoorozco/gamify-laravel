<ul class="nav navbar-nav">

    <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}">
            @lang('site.home')
            @if( request()->is('dashboard'))
                <span class="sr-only">(current)</span>
            @endif
        </a>
    </li>

    <li class="{{ request()->is('questions*') ? 'active' : '' }}">
        <a href="{{ route('questions.index') }}">
            @lang('site.play')
            @if ($questions_count > 0)
                <span class="label label-danger">{{ $questions_count }}</span>
            @endif
            @if( request()->is('questions*'))
                <span class="sr-only">(current)</span>
            @endif
        </a>
    </li>

</ul>
