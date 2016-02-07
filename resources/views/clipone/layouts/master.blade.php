<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'User Dashboard')</title>
    <!-- start: META -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="gamify v3: A Gamification Platform">
    <meta name="author" content="Paco Orozco">
    @yield('meta')
            <!-- end: META -->
    <!-- start: MAIN CSS -->
    <!-- Bootstrap core CSS -->
    {!! HTML::style(Theme::url('plugins/bootstrap/css/bootstrap.min.css')) !!}
    {!! HTML::style(Theme::url('css/style.css')) !!}
    <!-- end: MAIN CSS -->
    <!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
    @yield('styles')
    <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div id="wrap">

    <!-- start: FIXED NAVBAR -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('dashboard') }}"><img src="{{ Theme::url('images/logo-gow.png') }}" alt="Logo GoW!"></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <!-- start: SIDEBAR -->
            @include('user.sidebar')
            <!-- end: SIDEBAR -->
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> {{ Auth::user()->name }}<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="navbar-content">
                                <div class="row">
                                    <div class="col-md-5">
                                        <img src="{{ Auth::user()->profile->avatar->url() }}" alt="{{ trans('user/profile.avatar') }}" class="img-thumbnail img-responsive">
                                        <p class="small"></p>
                                    </div>
                                    <div class="col-md-7">
                                        <p class="text-muted small">{{ Auth::user()->email }}</p>
                                        <div class="divider"></div>
                                        <a href="{{ route('profile', array('user' => Auth::user())) }}" title="{{ trans('site.my_profile') }}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-user"></span> {{ trans('site.my_profile') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="navbar-footer">
                                <div class="navbar-footer-content">
                                    <div class="row">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6">
                                            <a href="{{ url('auth/logout') }}" title="{{ trans('auth.logout') }}" class="btn btn-danger btn-sm pull-right"><span class="glyphicon glyphicon-log-out"></span> {{ trans('auth.logout') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
    <!-- end: FIXED NAVBAR -->

<div class="container" role="main">

    <!-- start: PAGE CONTENT -->
    @yield('content')
    <!-- end: PAGE CONTENT-->

</div><!-- /.container -->

</div><!-- /.wrap -->
<footer id="footer">
    <div class="container">
        <p class="text-muted credit">2014-{!! date("Y") !!} &copy; {!! HTML::link('http://pacoorozco.info', 'Paco Orozco', ['rel' => 'nofollow']) !!} - Powered by {!! HTML::link('https://github.com/pacoorozco/gamify-l5', 'gamify v3', ['rel' => 'nofollow']) !!}</p>
    </div>
</footer>

<!-- start: MAIN JAVASCRIPTS -->
<!--[if lt IE 9]>
{!! HTML::script(Theme::url('plugins/respond.min.js')) !!}
{!! HTML::script(Theme::url('plugins/excanvas.min.js')) !!}
{!! HTML::script(Theme::url('plugins/jQuery-lib/1.10.2/jquery.min.js')) !!}
<![endif]-->
<!--[if gte IE 9]><!-->
{!! HTML::script(Theme::url('plugins/jQuery-lib/2.0.3/jquery.min.js')) !!}
<!--<![endif]-->
{!! HTML::script(Theme::url('plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js')) !!}
{!! HTML::script(Theme::url('plugins/bootstrap/js/bootstrap.min.js')) !!}

</body>
</html>
