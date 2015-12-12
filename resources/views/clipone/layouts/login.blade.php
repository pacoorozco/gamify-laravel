<!DOCTYPE html>
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
    <!-- start: HEAD -->
    <head>
        <title>@yield('title', 'Login Page')</title>
        <!-- start: META -->
        <meta charset="utf-8" />
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta content="gamify v3: A Gamification Platform" name="description" />
        <meta content="Paco Orozco" name="author" />
        @yield('meta')
        <!-- end: META -->
        <!-- start: MAIN CSS -->
        {!! HTML::style(Theme::url('plugins/bootstrap/css/bootstrap.min.css')) !!}
        {!! HTML::style(Theme::url('plugins/font-awesome/css/font-awesome.min.css')) !!}
        {!! HTML::style(Theme::url('fonts/style.css')) !!}
        {!! HTML::style(Theme::url('css/main.css')) !!}
        {!! HTML::style(Theme::url('css/main-responsive.css')) !!}
        {!! HTML::style(Theme::url('plugins/iCheck/skins/all.css')) !!}
        {!! HTML::style(Theme::url('plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css')) !!}
        {!! HTML::style(Theme::url('plugins/perfect-scrollbar/src/perfect-scrollbar.css')) !!}
        {!! HTML::style(Theme::url('css/theme_light.css'), ['id' => 'skin_color']) !!}
        {!! HTML::style(Theme::url('css/print.css'), ['media' => 'print']) !!}
        <!--[if IE 7]>
        {!! HTML::style(Theme::url('plugins/font-awesome/css/font-awesome-ie7.min.css')) !!}
        <![endif]-->
        <!-- end: MAIN CSS -->
        <!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
        @yield('styles')
        <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    </head>
    <!-- end: HEAD -->
    <!-- start: BODY -->
    <body class="login example1">
		<div class="main-login col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
			<div class="logo">gamify v3</div>
                        @yield('content')
			<!-- start: COPYRIGHT -->
			<div class="copyright">
				{!! date("Y") !!} &copy; {!! HTML::link('http://pacoorozco.info', 'Paco Orozco', ['rel' => 'nofollow']) !!} - Powered by {!! HTML::link('https://github.com/pacoorozco/gamify-l5', 'gamify v3', ['rel' => 'nofollow']) !!}
			</div>
			<!-- end: COPYRIGHT -->
		</div>
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
        {!! HTML::script(Theme::url('plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')) !!}
        {!! HTML::script(Theme::url('plugins/blockUI/jquery.blockUI.js')) !!}
        {!! HTML::script(Theme::url('plugins/iCheck/jquery.icheck.min.js')) !!}
        {!! HTML::script(Theme::url('plugins/perfect-scrollbar/src/jquery.mousewheel.js')) !!}
        {!! HTML::script(Theme::url('plugins/perfect-scrollbar/src/perfect-scrollbar.js')) !!}
        {!! HTML::script(Theme::url('plugins/less/less-1.5.0.min.js')) !!}
        {!! HTML::script(Theme::url('plugins/jquery-cookie/jquery.cookie.js')) !!}
        {!! HTML::script(Theme::url('plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js')) !!}
        {!! HTML::script(Theme::url('plugins/jquery-cookie/jquery.cookie.js')) !!}
        {!! HTML::script(Theme::url('js/main.js')) !!}
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