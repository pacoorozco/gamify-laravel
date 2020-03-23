<li class="dropdown user user-menu">
    <!-- Menu Toggle Button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <!-- The user image in the navbar-->
        <img src="{{ $user->profile->avatar }}" class="user-image"
             alt="@lang('user/profile.avatar')"/>
        <!-- hidden-xs hides the username on small devices so only the image appears. -->
        <span class="hidden-xs">{{ $user->name }}</span>
    </a>
    <ul class="dropdown-menu">
        <!-- The user image in the menu -->
        <li class="user-header">
            <img src="{{ $user->profile->avatar }}" class="img-circle"
                 alt="@lang('user/profile.avatar')"/>
            <p>
                {{ $user->name }} - {{ $user->level }}
                <small>@lang('user/profile.user_since') {{ $user->created_at }}</small>
            </p>
        </li>
        <!-- Menu Body -->
        <li class="user-body">
            <div class="col-xs-12 text-center">
                <a href="#">@lang('site.my_achievements')</a>
            </div>
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                <a href="{{ route('profiles.show', $user->username) }}" class="btn btn-default btn-flat">
                    @lang('site.my_profile')
                </a>
            </div>
            <div class="pull-right">
                {{ Form::open(['route' => 'logout']) }}
                {{ Form::submit(__('auth.logout'), ['class' => 'btn btn-default btn-flat']) }}
                {{ Form::close() }}
            </div>
        </li>
    </ul>
</li>
