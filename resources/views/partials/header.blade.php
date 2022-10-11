<header class="main-header">
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        <!-- start: CONTAINER -->
        <div class="container">
            <div class="navbar-header">
                <!-- start: LOGO -->
                <strong><a href="{{ route('home') }}" class="navbar-brand">{{ config('app.name', 'gamify') }}</a></strong>
                <!-- end: LOGO -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <!-- start: TOP LEFT NAVIGATION MENU -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                @include('partials.sidebar')
            </div>
            <!-- end: TOP LEFT NAVIGATION MENU -->

            <!-- start: TOP RIGHT NAVIGATION MENU -->
            <div class="navbar-custom-menu">
                <!-- start: TOP NAVIGATION MENU -->
                <ul class="nav navbar-nav">

                    @can('access-dashboard')
                        <li>
                            <a href="{{ route('admin.home') }}" title="{{ __('site.admin_area') }}">
                                <i class="fa fa-gears"></i>
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
                        <li>
                            <a href="{{ route('login') }}" title="{{ __('auth.login') }}">
                                {{ __('auth.login') }}
                            </a>
                        </li>
                    @endguest


                </ul>
                <!-- end: TOP RIGHT NAVIGATION MENU -->
            </div>


        </div>
        <!-- end: CONTAINER -->
    </nav>
</header>
