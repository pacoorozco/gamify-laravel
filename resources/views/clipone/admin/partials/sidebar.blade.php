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
                <span class="title"> {{ trans('admin/site.dashboard') }} </span>
                @if (Request::is('admin'))
                    <span class="selected"></span>
                @endif
            </a>
        </li>
        <li {!! (Request::is('admin/users*') ? ' class="active"' : '') !!}>
            <a href="{{ route('admin.users.index') }}"><i class="clip-users"></i>
                <span class="title"> {{ trans('admin/site.users') }} </span>
                @if (Request::is('admin/users*'))
                    <span class="selected"></span>
                @endif
            </a>
        </li>
        <li {!! (Request::is('admin/badges*') ? ' class="active"' : '') !!}>
            <a href="{{ route('admin.badges.index') }}"><i class="fa fa-gift"></i>
                <span class="title"> {{ trans('admin/site.badges') }} </span>
                @if (Request::is('admin/badges*'))
                    <span class="selected"></span>
                @endif
            </a>
        </li>
        <li {!! (Request::is('admin/levels*') ? ' class="active"' : '') !!}>
            <a href="{{ route('admin.levels.index') }}"><i class="fa fa-graduation-cap"></i>
                <span class="title"> {{ trans('admin/site.levels') }} </span>
                @if (Request::is('admin/levels*'))
                    <span class="selected"></span>
                @endif
            </a>
        </li>
        <li {!! (Request::is('admin/questions*') ? ' class="active"' : '') !!}>
            <a href="{{ route('admin.questions.index') }}"><i class="clip-bubbles-3"></i>
                <span class="title"> {{ trans('admin/site.questions') }} </span>
                @if (Request::is('admin/questions*'))
                    <span class="selected"></span>
                @endif
            </a>
        </li>
    </ul>
    <!-- end: MAIN NAVIGATION MENU -->
</div>
