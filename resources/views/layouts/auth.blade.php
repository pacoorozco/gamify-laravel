<!DOCTYPE html>
<html lang="en">
<!-- start: HEAD -->
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Administration Dashboard') :: {{ config('app.name', 'gamify') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- start: META -->
    <meta content="gamify: A Gamification Platform - Login" name="description">
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
<body class="login-page">
<!-- start: LOGIN BOX -->
<div class="login-box">
    <!-- start: NOTIFICATIONS -->
    @include('partials.notifications')
    <!-- end: NOTIFICATIONS -->

    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <p class="h1"><strong>{{ config('app.name', 'gamify') }}</strong></p>
        </div>
        <div class="card-body">
            @yield('content')
        </div>
    </div>
</div>
<!-- end: LOGIN BOX -->

<!-- start: GLOBAL JAVASCRIPT -->
<script src="{{ asset('vendor/AdminLTE/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/AdminLTE/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/AdminLTE/js/adminlte.min.js?v=3.2.0') }}"></script>
<!-- end: GLOBAL JAVASCRIPT -->
<!-- start: JAVASCRIPT REQUIRED FOR THIS PAGE ONLY -->
@stack('scripts')
<!-- end: JAVASCRIPT REQUIRED FOR THIS PAGE ONLY -->
</body>
<!-- end: BODY -->
</html>
