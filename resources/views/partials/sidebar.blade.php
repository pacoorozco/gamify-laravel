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
            @lang('site.play') <span class="badge">{{ Auth()->user()->pendingQuestions()->count() }}</span>
            @if( request()->is('questions*'))
                <span class="sr-only">(current)</span>
            @endif
        </a>
    </li>

    @can('admin')
        <li>
            <a href="{{ route('admin.home') }}" title="@lang('site.admin_area')">
                <i class="fa fa-gears"></i> @lang('site.admin_area')
            </a>
        </li>
    @endcan

</ul>
