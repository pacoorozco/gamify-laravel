<!-- start: MAIN NAVIGATION MENU -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">ADMIN NAVIGATION</li>
        <li class="nav-item">
            <a href="{{ route('admin.home') }}" @class([
    'nav-link',
    'active' => Request::is('admin'),
])>
                <i class="nav-icon bi bi-house-fill"></i>
                <p>{{ __('admin/site.dashboard') }}</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.users.index') }}" @class([
    'nav-link',
    'active' => Request::is('admin/users*'),
])>
                <i class="nav-icon bi bi-people-fill"></i>
                <p>{{ __('admin/site.users') }}</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.badges.index') }}" @class([
    'nav-link',
    'active' => Request::is('admin/badges*'),
])>
                <i class="nav-icon bi bi-award-fill"></i>
                <p>{{ __('admin/site.badges') }}</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.levels.index') }}" @class([
    'nav-link',
    'active' => Request::is('admin/levels*'),
])>
                <i class="nav-icon bi bi-mortarboard-fill"></i>
                <p>{{ __('admin/site.levels') }}</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.questions.index') }}" @class([
    'nav-link',
    'active' => Request::is('admin/questions*'),
])>
                <i class="nav-icon bi bi-question-octagon-fill"></i>
                <p>{{ __('admin/site.questions') }}</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.rewards.index') }}" @class([
    'nav-link',
    'active' => Request::is('admin/rewards*'),
])>
                <i class="nav-icon bi bi-trophy-fill"></i>
                <p>{{ __('admin/site.rewards') }}</p>
            </a>
        </li>
        <li class="nav-header">PLAY AREA</li>
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link">
                <i class="nav-icon bi bi-controller"></i>
                <p>{{ __('admin/site.play_area') }}</p>
            </a>
        </li>
    </ul>
    <!-- end: MAIN NAVIGATION MENU -->
</nav>
