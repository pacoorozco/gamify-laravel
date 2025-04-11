<!-- start: TOP NAVIGATION MENU -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <!-- start: RESPONSIVE MENU TOGGLER -->
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" role="button" href="#">
                <i class="bi bi-list"></i>
                <p class="sr-only">Toggle navigation</p>
            </a>
        </li>
        <!-- end: RESPONSIVE MENU TOGGLER -->
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link">
                <i class="bi bi-controller"></i>
                <p class="sr-only">{{ __('admin/site.play_area') }}</p>
            </a>
        </li>
        <!-- start: USER DROPDOWN -->
        @include('partials.user_dropdown')
        <!-- end: USER DROPDOWN -->
    </ul>
</nav>
<!-- end: TOP NAVIGATION MENU -->
