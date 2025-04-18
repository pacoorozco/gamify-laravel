<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ __('user/profile.about_me') }}</h3>
    </div>
    <!-- /.box-header -->
    <div class="card-body">
        <div class="text-center">
            <a class="btn @empty($user->profile->facebook) disabled @endempty" href="{{ $user->profile->facebook }}"
               rel="nofollow" target="_blank">
                <i class="bi bi-facebook"></i>
            </a>

            <a class="btn @empty($user->profile->twitter) disabled @endempty" href="{{ $user->profile->twitter }}"
               rel="nofollow" target="_blank">
                <i class="bi bi-twitter-x"></i>
            </a>

            <a class="btn @empty($user->profile->linkedin) disabled @endempty" href="{{ $user->profile->linkedin }}"
               rel="nofollow" target="_blank">
                <i class="bi bi-linkedin"></i>
            </a>

            <a class="btn @empty($user->profile->github) disabled @endempty" href="{{ $user->profile->github }}"
               rel="nofollow" target="_blank">
                <i class="bi bi-github"></i>
            </a>
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
