<li class="dropdown user user-menu">
    <!-- Menu Toggle Button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <!-- The user image in the navbar-->
        <img src="{{ $user->profile->avatarUrl }}" class="user-image"
             alt="{{ __('user/profile.avatar') }}"/>
        <!-- hidden-xs hides the username on small devices so only the image appears. -->
        <span class="hidden-xs">{{ $user->name }}</span>
    </a>
    <ul class="dropdown-menu">
        <!-- The user image in the menu -->
        <li class="user-header">
            <img src="{{ $user->profile->avatarUrl }}" class="img-circle"
                 alt="{{ __('user/profile.avatar') }}"/>
            <p>
                {{ $user->name }} - {{ $user->level }}
                <small>{{ __('user/profile.user_since') }} {{ $user->present()->createdAt }}</small>
            </p>
        </li>
        <!-- Menu Body -->
        <li class="user-body">
            <div class="col-xs-12 text-center">
                <a href="#">{{ __('site.my_achievements') }}</a>
            </div>
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                <a href="{{ route('account.index') }}" class="btn btn-default btn-flat">
                    {{ __('site.my_profile') }}
                </a>
            </div>
            <div class="pull-right">
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <input class="btn btn-default btn-flat" type="submit" value="{{ __('auth.logout') }}">
                </form>
            </div>
        </li>
    </ul>
</li>
