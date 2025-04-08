<!-- start: MAIN NAVIGATION MENU -->
<ul class="sidebar-menu">
    <li class="header">ADMIN NAVIGATION</li>
    <li {!! (Request::is('admin') ? ' class="active"' : '') !!}>
        <a href="{{ route('admin.home') }}">
            <i class="bi bi-house-fill"></i><span>{{ __('admin/site.dashboard') }}</span>
        </a>
    </li>
    <li {!! (Request::is('admin/users*') ? ' class="active"' : '') !!}>
        <a href="{{ route('admin.users.index') }}">
            <i class="bi bi-people-fill"></i><span>{{ __('admin/site.users') }}</span>
        </a>
    </li>
    <li {!! (Request::is('admin/badges*') ? ' class="active"' : '') !!}>
        <a href="{{ route('admin.badges.index') }}">
            <i class="bi bi-trophy-fill"></i><span>{{ __('admin/site.badges') }}</span>
        </a>
    </li>
    <li {!! (Request::is('admin/levels*') ? ' class="active"' : '') !!}>
        <a href="{{ route('admin.levels.index') }}">
            <i class="bi bi-mortardboard"></i><span>{{ __('admin/site.levels') }}</span>
        </a>
    </li>
    <li {!! (Request::is('admin/questions*') ? ' class="active"' : '') !!}>
        <a href="{{ route('admin.questions.index') }}">
            <i class="bi bi-question-octagon-fill"></i><span>{{ __('admin/site.questions') }}</span>
        </a>
    </li>
    <li {!! (Request::is('admin/rewards*') ? ' class="active"' : '') !!}>
        <a href="{{ route('admin.rewards.index') }}">
            <i class="bi bi-award"></i><span>{{ __('admin/site.rewards') }}</span>
        </a>
    </li>
    <li class="header">PLAY AREA</li>
    <li>
        <a href="{{ route('home') }}">
            <i class="bi bi-controller"></i><span>{{ __('admin/site.play_area') }}</span>
        </a>
    </li>
</ul>
<!-- end: MAIN NAVIGATION MENU -->
