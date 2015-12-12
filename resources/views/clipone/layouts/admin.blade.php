<!DOCTYPE html>
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
    <!-- start: HEAD -->
    <head>
        <title>@yield('title', 'Administration Dashboard')</title>
        <!-- start: META -->
        <meta charset="utf-8" />
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta content="gamify v3: A Gamification Platform - Administration" name="description" />
        <meta content="Paco Orozco" name="author" />
        @yield('meta')
        <!-- end: META -->
        <!-- start: MAIN CSS -->
        {!! Theme::css('plugins/bootstrap/css/bootstrap.min.css') !!}
        {!! Theme::css('plugins/font-awesome/css/font-awesome.min.css') !!}
        {!! Theme::css('fonts/style.css') !!}
        {!! Theme::css('css/main.css') !!}
        {!! Theme::css('css/main-responsive.css') !!}
        {!! Theme::css('plugins/iCheck/skins/all.css') !!}
        {!! Theme::css('plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css') !!}
        {!! Theme::css('plugins/perfect-scrollbar/src/perfect-scrollbar.css') !!}
        {!! Theme::css('css/theme_light.css'), array('id' => 'skin_color') !!}
        {!! Theme::css('css/print.css'), array('media' => 'print') !!}
        <!--[if IE 7]>
        {!! Theme::css('plugins/font-awesome/css/font-awesome-ie7.min.css') !!}
        <![endif]-->
        <!-- end: MAIN CSS -->
        <!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
        @yield('styles')
        <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    </head>
    <!-- end: HEAD -->
    <!-- start: BODY -->
    <body>
        <!-- start: HEADER -->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <!-- start: TOP NAVIGATION CONTAINER -->
            <div class="container">
                <div class="navbar-header">
                    <!-- start: RESPONSIVE MENU TOGGLER -->
                    <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                        <span class="clip-list-2"></span>
                    </button>
                    <!-- end: RESPONSIVE MENU TOGGLER -->
                    <!-- start: LOGO -->
                    <a class="navbar-brand" href="{!! URL::route('home') !!}">
                        gamify v3
                    </a>
                    <!-- end: LOGO -->
                </div>
                <div class="navbar-tools">
                    <!-- start: TOP NAVIGATION MENU -->
                    <ul class="nav navbar-right">
                        <!-- start: NOTIFICATION DROPDOWN -->
                        
                        <!-- end: NOTIFICATION DROPDOWN -->
                        <!-- start: USER DROPDOWN -->
                        <li class="dropdown current-user">
                            <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
                                {{ HTML::image(Auth::user()->profile->image->url('small'), null, array('class' => 'circle-img', 'height' => '30', 'width' => '30')) }}
                                <span class="username">{{ Auth::user()->fullname }}</span>
                                <i class="clip-chevron-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ URL::to('user') }}">
                                        <i class="clip-user-2"></i>
                                        &nbsp; {{ trans('site.my_profile') }}
                                    </a>
                                </li>
                                {{-- <li>
                                    <a href="#">
                                        <i class="fa fa-trophy"></i>
                                        &nbsp; {{ trans('site.my_achievements') }}
                                    </a>
                                </li> --}}
                                <li class="divider"></li>
                                <li>
                                    <a href="{{ URL::to('user/logout') }}">
                                        <i class="clip-exit"></i>
                                        &nbsp;{{ trans('general.logout') }}
                                    </a>
                                </li>
                                {{-- <li class="divider"></li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-bullhorn"></i>
                                        &nbsp; Report a problem
                                    </a>
                                </li> --}}
                            </ul>
                        </li>
                        <!-- end: USER DROPDOWN -->
                    </ul>
                    <!-- end: TOP NAVIGATION MENU -->
                </div>
            </div>
            <!-- end: TOP NAVIGATION CONTAINER -->
        </div>
        <!-- end: HEADER -->
        <!-- start: MAIN CONTAINER -->
        <div class="main-container">
            <div class="navbar-content">
                <!-- start: SIDEBAR -->
                @include('admin.sidebar')
                <!-- end: SIDEBAR -->
            </div>
            <!-- start: PAGE -->
            <div class="main-content">
                <div class="container">
                    <!-- start: PAGE HEADER -->
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- start: PAGE TITLE & BREADCRUMB -->
                            <ol class="breadcrumb">
                            @yield('breadcrumbs')
                            </ol>
                            <div class="page-header">
                                @yield('header', '<h1>Title <small>subtitle</small></h1>')
                            </div>
                            <!-- end: PAGE TITLE & BREADCRUMB -->
                        </div>
                    </div>
                    <!-- end: PAGE HEADER -->
                    <!-- start: PAGE CONTENT -->
                    @yield('content')
                    <!-- end: PAGE CONTENT-->
                </div>
            </div>
            <!-- end: PAGE -->
        </div>
        <!-- end: MAIN CONTAINER -->
        <!-- start: FOOTER -->
        <div class="footer clearfix">
            <div class="footer-inner">
                {{ date("Y"); }} &copy; {!! HTML::link('http://pacoorozco.info', 'Paco Orozco', ['rel' => 'nofollow']) !!} - Powered by {!! HTML::link('https://github.com/pacoorozco/laravel-gamify', 'gamify v3', ['rel' => 'nofollow']) !!}
            </div>
            <div class="footer-items">
                <span class="go-top"><i class="clip-chevron-up"></i></span>
            </div>
        </div>
        <!-- end: FOOTER -->
        <!-- start: MAIN JAVASCRIPTS -->
        <!--[if lt IE 9]>
        {!! Theme::js('plugins/respond.min.js')) !!}
        {!! Theme::js('plugins/excanvas.min.js')) !!}
        {!! Theme::js('plugins/jQuery-lib/1.10.2/jquery.min.js')) !!}
        <![endif]-->
        <!--[if gte IE 9]><!-->
        {!! Theme::js('plugins/jQuery-lib/2.0.3/jquery.min.js')) !!}
        <!--<![endif]-->
        {!! Theme::js('plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js')) !!}
        {!! Theme::js('plugins/bootstrap/js/bootstrap.min.js')) !!}
        {!! Theme::js('plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')) !!}
        {!! Theme::js('plugins/blockUI/jquery.blockUI.js')) !!}
        {!! Theme::js('plugins/iCheck/jquery.icheck.min.js')) !!}
        {!! Theme::js('plugins/perfect-scrollbar/src/jquery.mousewheel.js')) !!}
        {!! Theme::js('plugins/perfect-scrollbar/src/perfect-scrollbar.js')) !!}
        {!! Theme::js('plugins/less/less-1.5.0.min.js')) !!}
        {!! Theme::js('plugins/jquery-cookie/jquery.cookie.js')) !!}
        {!! Theme::js('plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js')) !!}
        {!! Theme::js('plugins/jquery-cookie/jquery.cookie.js')) !!}
        {!! Theme::js('js/main.js')) !!}
        <!-- end: MAIN JAVASCRIPTS -->
        <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
        @yield('scripts')
        <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
        <script>
            jQuery(document).ready(function () {
                Main.init();
            });
        </script>
    </body>
    <!-- end: BODY -->
</html>