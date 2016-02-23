<li class="active">
    <a href="{{ route('dashboard') }}" title="{{ trans('site.home') }}">
        {{ trans('site.home') }}
        <span class="sr-only">(current)</span>
    </a>
</li>
<li>
    <a href="#" title="{{ trans('site.play') }}">
        {{ trans('site.play') }} <span class="badge">1</span>
    </a>
</li>
<li><a href="#">Link</a></li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="#">Action</a></li>
        <li><a href="#">Another action</a></li>
        <li><a href="#">Something else here</a></li>
        <li class="divider"></li>
        <li><a href="#">Separated link</a></li>
        <li class="divider"></li>
        <li><a href="#">One more separated link</a></li>
    </ul>
</li>
@can('admin')
<li>
    <a href="{{ route('admin-home') }}" title="{{ trans('site.admin_area') }}">
        {{ trans('site.admin_area') }}
    </a>
</li>
@endcan