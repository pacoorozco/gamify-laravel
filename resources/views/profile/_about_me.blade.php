<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('user/profile.about_me') }}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="text-center">
            @if (!empty($user->profile->facebook))
                <a class="btn btn-social-icon btn-facebook" href="{{ $user->profile->facebook }}"
                   rel="nofollow">
                    <i class="fa fa-facebook"></i>
                </a>
            @else
                <button type="button" class="btn btn-social-icon btn-facebook disabled">
                    <i class="fa fa-facebook"></i>
                </button>
            @endif
            @if (!empty($user->profile->twitter))
                <a class="btn btn-social-icon btn-twitter" href="{{ $user->profile->twitter }}"
                   rel="nofollow">
                    <i class="fa fa-twitter"></i>
                </a>
            @else
                <button type="button" class="btn btn-social-icon btn-twitter disabled">
                    <i class="fa fa-twitter"></i>
                </button>
            @endif
            @if (!empty($user->profile->linkedin))
                <a class="btn btn-social-icon btn-linkedin" href="{{ $user->profile->linkedin }}"
                   rel="nofollow">
                    <i class="fa fa-linkedin"></i>
                </a>
            @else
                <button type="button" class="btn btn-social-icon btn-linkedin disabled">
                    <i class="fa fa-linkedin"></i>
                </button>
            @endif
            @if (!empty($user->profile->googleplus))
                <a class="btn btn-social-icon btn-google" href="{{ $user->profile->googleplus }}"
                   rel="nofollow">
                    <i class="fa fa-google-plus"></i>
                </a>
            @else
                <button type="button" class="btn btn-social-icon btn-google disabled">
                    <i class="fa fa-google-plus"></i>
                </button>
            @endif
            @if (!empty($user->profile->github))
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
                <th colspan="2">{{ trans('user/profile.contact_info') }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ trans('user/profile.url') }}:</td>
                <td>
                    @if (!empty($user->profile->url))
                        <a href="{{ $user->profile->url }}" rel="nofollow">{{ $user->profile->url }}</a>
                    @endif
                </td>

            </tr>
            <tr>
                <td>{{ trans('user/profile.email') }}:</td>
                <td>
                    <a href="mailto:{{ $user->email }}" rel="nofollow">
                        {{ $user->email }}
                    </a>
                </td>
            </tr>
            <tr>
                <td>{{ trans('user/profile.phone') }}:</td>
                <td>
                    @if (!empty($user->profile->phone))
                        <a href="tel:{{ $user->profile->phone }}"
                           rel="nofollow">{{ $user->profile->phone }}</a>
                    @endif
                </td>
            </tr>
            <tr>
                <td>{{ trans('user/profile.mobile') }}:</td>
                <td>
                    @if (!empty($user->profile->mobile))
                        <a href="tel:{{ $user->profile->mobile }}"
                           rel="nofollow">{{ $user->profile->mobile }}</a>
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
        <hr>
        <table class="table table-condensed table-hover">
            <thead>
            <tr>
                <th colspan="2">{{ trans('user/profile.general_info') }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ trans('user/profile.level') }}:</td>
                <td>TODO UI Designer</td>
            </tr>
            <tr>
                <td>{{ trans('user/profile.rank') }}:</td>
                <td>TODO</td>
            </tr>
            <tr>
                <td>{{ trans('user/profile.user_since') }}:</td>
                <td>{{ date("M Y", strtotime($user->created_at)) }}</td>
            </tr>

            <tr>
                <td>{{ trans('user/profile.last_logged') }}:</td>
                <td>TODO min</td>
            </tr>
            <tr>
                <td>{{ trans('user/profile.roles') }}:</td>
                <td>
                    <span class="label label-sm label-info">TODO: User</span></td>
            </tr>
            </tbody>
        </table>
        <hr>
        <table class="table table-condensed table-hover">
            <thead>
            <tr>
                <th colspan="2">{{ trans('user/profile.additional_info') }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ trans('user/profile.birth') }}</td>
                <td>
                    @if (isset($user->profile->date_of_birth))
                        {{ date("d F Y", strtotime($user->profile->date_of_birth)) }}
                    @endif
                </td>
            </tr>
            <tr>
                <td>{{ trans('user/profile.gender') }}</td>
                <td>
                    @if (isset($user->profile->gender))
                        <i class="fa fa-{{ $user->profile->gender }}"></i>
                        {{ trans('user/profile.gender_' . $user->profile->gender) }}
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
</div>