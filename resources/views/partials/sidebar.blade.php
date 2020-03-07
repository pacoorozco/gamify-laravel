<ul class="nav navbar-nav">
    <li {!! (Request::is('dashboard') ? ' class="active"' : '') !!}>
        <a href="{{ route('dashboard') }}" title="{{ __('site.home') }}">
            {{ __('site.home') }}
            @if(Request::is('dashboard'))
                <span class="sr-only">(current)</span>
            @endif
        </a>
    </li>
    <li {!! (Request::is('questions*') ? ' class="active"' : '') !!}>
        <a href="{{ route('questions.index') }}" title="{{ __('site.play') }}">
            {{ __('site.play') }} <span class="badge">{{ Auth()->user()->pendingQuestions()->count() }}</span>
            @if(Request::is('questions*'))
                <span class="sr-only">(current)</span>
            @endif
        </a>
    </li>
    @can('admin')
    <li>
        <a href="{{ route('admin.home') }}" title="{{ __('site.admin_area') }}">
            <i class="fa fa-gears"></i> {{ __('site.admin_area') }}
        </a>
    </li>
    @endcan
</ul>
