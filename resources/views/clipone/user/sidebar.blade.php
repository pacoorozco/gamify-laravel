<div class="main-navigation navbar-collapse collapse">
    <!-- start: MAIN MENU TOGGLER BUTTON -->
    <div class="navigation-toggler">
        <i class="clip-chevron-left"></i>
        <i class="clip-chevron-right"></i>
    </div>
    <!-- end: MAIN MENU TOGGLER BUTTON -->
    <!-- start: MAIN NAVIGATION MENU -->
    <ul class="main-navigation-menu">
        <li {{ (Request::is('/') ? ' class="active"' : '') }}>
            <a href="{{ URL::route('home') }}"><i class="clip-home-3"></i>
                <span class="title"> {{ trans('site.home') }} </span>
            </a>
        </li>
        <li>
            <a href="question"><i class="clip-bubbles-3"></i>
                <span class="title"> {{ trans('site.play') }} </span>
            </a>
        </li>
        @if (Auth::user()->hasRole("admin"))
        <li>
            <a href="{{ URL::route('admin-home') }}"><i class="fa fa-gears"></i>
                <span class="title"> {{ trans('site.admin_area') }} </span>
            </a>
        </li>
        @endif
    </ul>
    <!-- end: MAIN NAVIGATION MENU -->
</div>
