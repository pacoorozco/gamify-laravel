
<div class="row">
    <div class="col-sm-12">
        <div class="tabbable">
            <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue">
                <li class="active">
                    <a data-toggle="tab" href="#panel_overview">
                        {{ trans('user/profile.overview') }}
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#panel_badges">
                        {{ trans('user/profile.badges') }}
                    </a>
                </li>
                @if ($user->isCurrent())
                <li>
                    <a data-toggle="tab" href="#panel_edit_account">
                        {{ trans('user/profile.edit_account') }}
                    </a>
                </li>
                @endif
            </ul>
            <div class="tab-content">
                <div id="panel_overview" class="tab-pane in active">
                    <div class="row">
                        <div class="col-sm-5 col-md-4">
                            <div class="user-left">
                                <div class="center">
                                    <h4>{{ $user->fullname }}</h4>
                                    <div class="user-image">
                                        <img src="{{ $user->profile->image->url('medium') }}" width="150">
                                    </div>
                                    <hr>
                                    <p>
                                        @if (!empty($user->profile->facebook))
                                        <a class="btn btn-twitter btn-sm btn-squared" href="{{{ $user->profile->facebook }}}">
                                            <i class="fa fa-facebook"></i>
                                        </a>                                        
                                        @endif
                                        @if (!empty($user->profile->twitter))
                                        <a class="btn btn-twitter btn-sm btn-squared" href="{{{ $user->profile->twitter }}}">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                        @endif
                                        @if (!empty($user->profile->linkedin))
                                        <a class="btn btn-linkedin btn-sm btn-squared" href="{{{ $user->profile->linkedin }}}">
                                            <i class="fa fa-linkedin"></i>
                                        </a>
                                        @endif
                                        @if (!empty($user->profile->googleplus))
                                        <a class="btn btn-google-plus btn-sm btn-squared" href="{{{ $user->profile->googleplus }}}">
                                            <i class="fa fa-google-plus"></i>
                                        </a>
                                        @endif
                                        @if (!empty($user->profile->github))
                                        <a class="btn btn-github btn-sm btn-squared" href="{{{ $user->profile->github }}}">
                                            <i class="fa fa-github"></i>
                                        </a>
                                        @endif
                                    </p>
                                    <hr>
                                </div>
                                <table class="table table-condensed table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="3">{{ trans('user/profile.contact_info') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ trans('user/profile.url') }}:</td>
                                            <td>
                                                @if (!empty($user->profile->url))
                                                <a href="{{{ $user->profile->url }}}">{{{ $user->profile->url }}}</a>
                                                @endif
                                            </td>
                                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('user/profile.email') }}:</td>
                                            <td>
                                                <a href="mailto:{{{ $user->email }}}">{{{ $user->email }}}</a>
                                            </td>
                                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('user/profile.phone') }}:</td>
                                            <td>
                                                {{{ (isset($user->profile->phone)) ? $user->profile->phone : '' }}}
                                            </td>
                                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('user/profile.mobile') }}:</td>
                                            <td>
                                                {{{ (isset($user->profile->mobile)) ? $user->profile->mobile : '' }}}
                                            </td>
                                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('user/profile.skype') }}</td>
                                            <td>
                                                @if (!empty($user->profile->skype))
                                                <a href="skype:{{{ $user->profile->skype }}}?call">{{{ $user->profile->skype }}}</a>
                                                @endif
                                            </td>
                                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                            <td>{{{ $user->created_at->format('M Y') }}}</td>
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
                                <table class="table table-condensed table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="3">{{ trans('user/profile.additional_info') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ trans('user/profile.birth') }}</td>
                                            <td>
                                                @if (isset($user->profile->date_of_birth))
                                                {{{ date("d F Y",strtotime($user->profile->date_of_birth)) }}}
                                                @endif
                                            </td>
                                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('user/profile.gender') }}</td>
                                            <td>
                                                @if (isset($user->profile->gender))
                                                {{ trans('user/profile.gender_' . $user->profile->gender) }}
                                                @endif
                                            </td>
                                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-7 col-md-8">
                            @if (isset($user->profile->bio))
                            {{{ $user->profile->bio }}}
                            @endif
                            <!-- start: RECENT ACTIVITIES -->
                            {{--
                            <div class="panel panel-white">
                                <div class="panel-heading">
                                    <i class="clip-menu"></i>
                                    Recent Activities
                                    <div class="panel-tools">
                                        <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                        </a>
                                        <a class="btn btn-xs btn-link panel-refresh" href="#">
                                            <i class="fa fa-refresh"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="panel-body panel-scroll" style="height:300px">
                                    <ul class="activities">
                                        <li>
                                            <a class="activity" href="javascript:void(0)">
                                                <i class="clip-upload-2 circle-icon circle-green"></i>
                                                <span class="desc">You uploaded a new release.</span>
                                                <div class="time">
                                                    <i class="fa fa-time bigger-110"></i>
                                                    2 hours ago
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="activity" href="javascript:void(0)">
                                                <i class="clip-data circle-icon circle-bricky"></i>
                                                <span class="desc">DataBase Migration.</span>
                                                <div class="time">
                                                    <i class="fa fa-time bigger-110"></i>
                                                    5 hours ago
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="activity" href="javascript:void(0)">
                                                <i class="clip-clock circle-icon circle-teal"></i>
                                                <span class="desc">You added a new event to the calendar.</span>
                                                <div class="time">
                                                    <i class="fa fa-time bigger-110"></i>
                                                    8 hours ago
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="activity" href="javascript:void(0)">
                                                <i class="clip-images-2 circle-icon circle-green"></i>
                                                <span class="desc">Kenneth Ross uploaded new images.</span>
                                                <div class="time">
                                                    <i class="fa fa-time bigger-110"></i>
                                                    9 hours ago
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="activity" href="javascript:void(0)">
                                                <i class="clip-image circle-icon circle-green"></i>
                                                <span class="desc">Peter Clark uploaded a new image.</span>
                                                <div class="time">
                                                    <i class="fa fa-time bigger-110"></i>
                                                    12 hours ago
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            --}}
                            <!-- end: RECENT ACTIVITIES -->
                        </div>
                    </div>
                </div>
                
                <div id="panel_badges" class="tab-pane">
                    @include('user/profile/_badges', compact('user'))
                </div>
                
                @if ($user->isCurrent())
                <div id="panel_edit_account" class="tab-pane">
                    @include('user/profile/_form', compact('user'))
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

