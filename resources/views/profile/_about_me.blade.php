<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('user/profile.about_me') }}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="text-center">
            @if ($user->profile->facebook)
                <a class="btn btn-social-icon btn-facebook" href="{{ $user->profile->facebook }}"
                   rel="nofollow">
                    <i class="fa fa-facebook"></i>
                </a>
            @else
                <button type="button" class="btn btn-social-icon btn-facebook disabled">
                    <i class="fa fa-facebook"></i>
                </button>
            @endif
            @if ($user->profile->twitter)
                <a class="btn btn-social-icon btn-twitter" href="{{ $user->profile->twitter }}"
                   rel="nofollow">
                    <i class="fa fa-twitter"></i>
                </a>
            @else
                <button type="button" class="btn btn-social-icon btn-twitter disabled">
                    <i class="fa fa-twitter"></i>
                </button>
            @endif
            @if ($user->profile->linkedin)
                <a class="btn btn-social-icon btn-linkedin" href="{{ $user->profile->linkedin }}"
                   rel="nofollow">
                    <i class="fa fa-linkedin"></i>
                </a>
            @else
                <button type="button" class="btn btn-social-icon btn-linkedin disabled">
                    <i class="fa fa-linkedin"></i>
                </button>
            @endif
            @if ($user->profile->github)
                <a class="btn btn-social-icon btn-github" href="{{ $user->profile->github }}"
                   rel="nofollow">
                    <i class="fa fa-github"></i>
                </a>
            @else
                <button type="button" class="btn btn-social-icon btn-github disabled">
                    <i class="fa fa-github"></i>
                </button>
            @endif
        </div>
        <hr>
        <table class="table table-condensed table-hover">
            <thead>
            <tr>
                <th colspan="2">{{ __('user/profile.general_info') }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ __('user/profile.level') }}:</td>
                <td>{{ $user->level }}</td>
            </tr>
            <tr>
                <td>{{ __('user/profile.badges') }}:</td>
                <td>{{ $user->unlockedBadgesCount() }}</td>
            </tr>
            <tr>
                <td>{{ __('user/profile.experience') }}:</td>
                <td>{{ $user->experience }}</td>
            </tr>
            <tr>
                <td>{{ __('user/profile.user_since') }}:</td>
                <td>{{ $user->present()->createdAt }}</td>
            </tr>
            <tr>
                <td>{{ __('user/profile.roles') }}:</td>
                <td>{{ $user->present()->role }}</td>
            </tr>
            </tbody>
        </table>
        <hr>
        <table class="table table-condensed table-hover">
            <thead>
            <tr>
                <th colspan="2">{{ __('user/profile.additional_info') }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ __('user/profile.date_of_birth') }}</td>
                <td>
                    {{ $user->present()->birthdate }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
</div>
