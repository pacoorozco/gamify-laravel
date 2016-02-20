    <!-- start: MAIN NAVIGATION MENU -->
    <ul class="nav navbar-nav">
        <li><a href="{{ route('dashboard') }}" title="{{ trans('site.home') }}"><span class="glyphicon glyphicon-home"></span> {{ trans('site.home') }}</a></li>
        <li><a href="#" title="{{ trans('site.play') }}"><span class="glyphicon glyphicon-question-sign"></span> {{ trans('site.play') }} <span class="badge">1</span></a></li>

        @can('admin')
        <li><a href="{{ route('admin-home') }}" title="{{ trans('site.admin_area') }}"><span class="glyphicon glyphicon-tasks"></span> {{ trans('site.admin_area') }}</a></li>
        @endcan
    </ul>
    <!-- end: MAIN NAVIGATION MENU -->

