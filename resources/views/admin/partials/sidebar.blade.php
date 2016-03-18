<!-- start: MAIN NAVIGATION MENU -->
<ul class="sidebar-menu">
    <li class="header">ADMIN NAVIGATION</li>
    <li {!! (Request::is('admin') ? ' class="active"' : '') !!}>
        <a href="{{ route('admin-home') }}">
            <i class="fa fa-dashboard"></i><span>{{ trans('admin/site.dashboard') }}</span>
        </a>
    </li>
    <li {!! (Request::is('admin/users*') ? ' class="active"' : '') !!}>
        <a href="{{ route('admin.users.index') }}">
            <i class="fa fa-users"></i><span>{{ trans('admin/site.users') }}</span>
        </a>
    </li>
    <li {!! (Request::is('admin/badges*') ? ' class="active"' : '') !!}>
        <a href="{{ route('admin.badges.index') }}">
            <i class="fa fa-trophy"></i><span>{{ trans('admin/site.badges') }}</span>
        </a>
    </li>
    <li {!! (Request::is('admin/levels*') ? ' class="active"' : '') !!}>
        <a href="{{ route('admin.levels.index') }}">
            <i class="fa fa-graduation-cap"></i><span>{{ trans('admin/site.levels') }}</span>
        </a>
    </li>
    <li {!! (Request::is('admin/questions*') ? ' class="active"' : '') !!}>
        <a href="{{ route('admin.questions.index') }}">
            <i class="fa fa-comments"></i><span>{{ trans('admin/site.questions') }}</span>
        </a>
    </li>
    <li {!! (Request::is('admin/rewards*') ? ' class="active"' : '') !!}>
        <a href="{{ route('admin.rewards.index') }}">
            <i class="fa fa-bank"></i><span>{{ trans('admin/site.rewards') }}</span>
        </a>
    </li>
    <li class="header">PLAY AREA</li>
    <li><a href="#">Questions</a></li>
</ul>
<!-- end: MAIN NAVIGATION MENU -->