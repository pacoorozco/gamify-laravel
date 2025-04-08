<!DOCTYPE html>
<html lang="en">
<!-- start: HEAD -->
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Administration Dashboard') :: {{ config('app.name', 'gamify') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- start: META -->
    <meta content="gamify: A Gamification Platform - Administration" name="description">
    <meta content="Paco Orozco" name="author">
    @yield('meta')
    <!-- end: META -->
    <!-- start: GLOBAL CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/AdminLTE/css/adminlte.min.css?v=3.2.0') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}">
    <!-- end: GLOBAL CSS -->
    <!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
    @stack('styles')
    <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
</head>
<!-- end: HEAD -->
<!-- start: BODY -->
<body class="sidebar-mini layout-fixed">
<!-- start: MAIN CONTAINER -->
<div class="wrapper">

    <!-- start: HEADER -->
    @include('admin.partials.header')
    <!-- end: HEADER -->

    <!-- start: SIDEBAR -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- start: LOGO -->
        <a href="{{ route('admin.home') }}" class="brand-link">
            {{--                <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">--}}
            <span class="brand-text font-weight-light">{{ config('app.name', 'gamify') }}</span>
        </a>
        <!-- end: LOGO -->

        <div class="sidebar">
            @include('admin.partials.sidebar')
        </div>
    </aside>
    <!-- end: SIDEBAR -->

    <!-- start: PAGE -->
    <div class="content-wrapper">
        <!-- start: PAGE HEADER -->
        <div class="content-header">
            <div class="container-fluid">

                <!-- start: PAGE TITLE & BREADCRUMB -->
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            @yield('header', 'Title <small>page description</small>')
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @yield('breadcrumbs')
                        </ol>
                    </div>
                </div>
                <!-- end: PAGE TITLE & BREADCRUMB -->
            </div>
        </div>
        <!-- end: PAGE HEADER -->

        <!-- start: PAGE CONTENT -->
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
        <!-- end: PAGE CONTENT-->
    </div>
    <!-- end: PAGE -->

    <!-- start: FOOTER -->
    @include('admin.partials.footer')
    <!-- end: FOOTER -->
</div>
<!-- end: MAIN CONTAINER -->
<!-- start: GLOBAL JAVASCRIPT -->
<script src="{{ asset('vendor/AdminLTE/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/AdminLTE/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/AdminLTE/js/adminlte.min.js?v=3.2.0') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<!-- end: GLOBAL JAVASCRIPT -->
<!-- start: JAVASCRIPT REQUIRED FOR THIS PAGE ONLY -->
@stack('scripts')
<!-- end: JAVASCRIPT REQUIRED FOR THIS PAGE ONLY -->
</body>
<!-- end: BODY -->
</html>

