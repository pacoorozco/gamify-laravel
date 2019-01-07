<ul class="nav navbar-nav">
    <li {!! (Request::is('dashboard') ? ' class="active"' : '') !!}>
        <a href="{{ route('dashboard') }}" title="{{ trans('site.home') }}">
            {{ trans('site.home') }}
            @if(Request::is('dashboard'))
                <span class="sr-only">(current)</span>
            @endif
        </a>
    </li>
    <li {!! (Request::is('questions*') ? ' class="active"' : '') !!}>
        <a href="{{ route('questions.index') }}" title="{{ trans('site.play') }}">
            {{ trans('site.play') }} <span class="badge">{{ Auth()->user()->getPendingQuestions()->count() }}</span>
            @if(Request::is('questions*'))
                <span class="sr-only">(current)</span>
            @endif
        </a>
    </li>
    @can('admin')
    <li>
        <a href="{{ route('admin.home') }}" title="{{ trans('site.admin_area') }}">
            <i class="fa fa-gears"></i> {{ trans('site.admin_area') }}
        </a>
    </li>
    @endcan
</ul>
