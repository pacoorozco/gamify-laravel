<div class="main-navigation navbar-collapse collapse">
    <!-- start: MAIN MENU TOGGLER BUTTON -->
    <div class="navigation-toggler">
        <i class="clip-chevron-left"></i>
        <i class="clip-chevron-right"></i>
    </div>
    <!-- end: MAIN MENU TOGGLER BUTTON -->
    <!-- start: MAIN NAVIGATION MENU -->
    <ul class="main-navigation-menu">
        <li {!! (Request::is('admin') ? ' class="active"' : '') !!}>
            <a href="{{ route('admin-home') }}"><i class="clip-home-3"></i>
                <span class="title"> {{ trans('admin/site.dashboard') }} </span><span class="selected"></span>
            </a>
        </li>
        <li {!! (Request::is('admin/users*') ? ' class="active"' : '') !!}>
            <a href="{{ route('admin.users.index') }}"><i class="clip-users"></i>
                <span class="title"> {{ trans('admin/site.users') }} </span>
            </a>
        </li>
        <li {!! (Request::is('admin/badges*') ? ' class="active"' : '') !!}>
            <a href="{{ route('admin.badges.index') }}"><i class="fa fa-gift"></i>
                <span class="title"> {{ trans('admin/site.badges') }} </span>
            </a>
        </li>
        <li {!! (Request::is('admin/levels*') ? ' class="active"' : '') !!}>
            <a href="{{ route('admin.levels.index') }}"><i class="fa fa-graduation-cap"></i>
                <span class="title"> {{ trans('admin/site.levels') }} </span>
            </a>
        </li>
        <li {!! (Request::is('admin/questions*') ? ' class="active"' : '') !!}>
            <a href="{{ route('admin.questions.index') }}"><i class="clip-bubbles-3"></i>
                <span class="title"> {{ trans('admin/site.questions') }} </span>
            </a>
        </li>
    </ul>
    <!-- end: MAIN NAVIGATION MENU -->
</div>
