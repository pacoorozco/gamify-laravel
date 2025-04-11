<!-- Header Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <!-- start: CONTAINER -->
    <div class="container">

        <!-- start: LOGO -->
        <a href="{{ route('home') }}" class="navbar-brand">
            <span class="brand-text font-weight-bolder">{{ config('app.name', 'gamify') }}</span>
        </a>
        <!-- end: LOGO -->

        <button type="button" class="navbar-toggler order-1" data-toggle="collapse"
                data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- start: TOP LEFT NAVIGATION MENU -->
        <div class="collapse navbar-collapse order-3" id="navbar-collapse">
            @include('partials.sidebar')
        </div>
        <!-- end: TOP LEFT NAVIGATION MENU -->

        <!-- start: TOP RIGHT NAVIGATION MENU -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

            @can('access-dashboard')
                <li class="nav-item">
                    <a href="{{ route('admin.home') }}" title="{{ __('site.admin_area') }}" class="nav-link">
                        <i class="bi bi-house-gear-fill"></i>
                    </a>
                </li>
            @endcan

            {{--
            <!-- start: NOTIFICATION DROPDOWN -->
            <!-- end: NOTIFICATION DROPDOWN -->
            --}}

            @auth
                <!-- start: USER DROPDOWN -->
                @include('partials.user_dropdown')
                <!-- end: USER DROPDOWN -->
            @endauth

            @guest
                <li class="nav-item">
                    <a href="{{ route('login') }}" title="{{ __('auth.login') }}" class="nav-link">
                        {{ __('auth.login') }}
                    </a>
                </li>
            @endguest


        </ul>
        <!-- end: TOP RIGHT NAVIGATION MENU -->

    </div>
    <!-- end: CONTAINER -->
</nav>

