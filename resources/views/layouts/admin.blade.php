<!DOCTYPE html>
<html lang="en">
<!-- start: HEAD -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Administration Dashboard') :: {{ config('app.name', 'gamify') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- start: META -->
    <meta content="gamify: A Gamification Platform - Administration" name="description">
    <meta content="Paco Orozco" name="author">
    @yield('meta')
    <!-- end: META -->
    <!-- start: GLOBAL CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/AdminLTE/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css') }}">
    <!-- end: GLOBAL CSS -->
    <!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
    @stack('styles')
    <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
    <!-- start: MAIN CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/AdminLTE/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/AdminLTE/css/skins/skin-blue.min.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{ asset('//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('//oss.maxcdn.com/respond/1.4.2/respond.min.js') }}"></script>
    <![endif]-->
    <!-- end: MAIN CSS -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
</head>
<!-- end: HEAD -->
<!-- start: BODY -->
<body class="skin-blue sidebar-mini">
<!-- start: MAIN CONTAINER -->
<div class="wrapper">

    <!-- start: HEADER -->
    @include('admin.partials.header')
    <!-- end: HEADER -->

    <!-- start: SIDEBAR -->
    <aside class="main-sidebar">
        <section class="sidebar">
            @include('admin.partials.sidebar')
        </section>
    </aside>
    <!-- end: SIDEBAR -->

    <!-- start: PAGE -->
    <div class="content-wrapper">
        <!-- start: PAGE HEADER -->
        <section class="content-header">
            <!-- start: PAGE TITLE & BREADCRUMB -->
            <h1>
                @yield('header', 'Title <small>page description</small>')
            </h1>
            <ol class="breadcrumb">
                @yield('breadcrumbs')
            </ol>
            <!-- end: PAGE TITLE & BREADCRUMB -->
        </section>
        <!-- end: PAGE HEADER -->

        <!-- start: PAGE CONTENT -->
        <section class="content">
            @yield('content')
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
<script src="{{ asset('vendor/AdminLTE/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/AdminLTE/js/adminlte.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<!-- end: GLOBAL JAVASCRIPT -->
<!-- start: JAVASCRIPT REQUIRED FOR THIS PAGE ONLY -->
@stack('scripts')
<!-- end: JAVASCRIPT REQUIRED FOR THIS PAGE ONLY -->
</body>
<!-- end: BODY -->
</html>

