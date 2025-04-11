<li class="nav-item dropdown user-menu">
    <!-- Menu Toggle Button -->
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <!-- The user image in the navbar-->
        <img src="{{ $user->profile->avatarUrl }}" class="user-image img-circle elevation-2"
             alt="{{ __('user/profile.avatar') }}">
        <!-- hidden-xs hides the username on small devices so only the image appears. -->
        <span class="d-none d-md-inline">{{ $user->name }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <!-- The user image in the menu -->
        <li class="user-header bg-primary">
            <img src="{{ $user->profile->avatarUrl }}" class="img-circle elevation-2"
                 alt="{{ __('user/profile.avatar') }}">
            <p>
                {{ $user->name }} - {{ $user->level }}
                <small>{{ __('user/profile.user_since') }} {{ $user->present()->createdAt }}</small>
            </p>
        </li>
        <!-- Menu Body -->
        <li class="user-body">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <a href="#">{{ __('site.my_achievements') }}</a>
                </div>
            </div>
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
            <a href="{{ route('account.index') }}" class="btn btn-outline-primary btn-flat">
                {{ __('site.my_profile') }}
            </a>

            <div class="float-right">
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <input class="btn btn-block btn-outline-danger" type="submit" value="{{ __('auth.logout') }}">
                </form>
            </div>
        </li>
    </ul>
</li>
