@extends('layouts.master')

{{-- Web site Title --}}
@section('title', __('user/profile.title'))

{{-- Content Header --}}
@section('header', __('user/profile.title'))

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('home') }}">
            <i class="fa fa-dashboard"></i> {{ __('site.home') }}
        </a>
    </li>
    <li class="active">
        {{ __('user/profile.title') }}
    </li>
@endsection

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-md-4">

            <!-- Profile Image -->
            <div class="box box-widget widget-user">
                <div class="widget-user-header bg-aqua-active">
                    <h3 class="widget-user-username">{{ $user->name }}</h3>
                    <h5 class="widget-user-desc">{{ $user->level }}</h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="{{ $user->profile->avatarUrl }}" alt="User Avatar">
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{ $user->experience }}</h5>
                                <span class="description-text">XP</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{ $user->answeredQuestionsCount() }}</h5>
                                <span class="description-text">ANSWERS</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block">
                                <h5 class="description-header">{{ $user->unlockedBadgesCount() }}</h5>
                                <span class="description-text">BADGES</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.profile image -->

            <!-- About Me -->
            @include('profile._about_me')
            <!-- /.about me -->

        </div>
        <div class="col-md-8">
            <!-- notifications -->
            @include('partials.notifications')
            <!-- ./notifications -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#overview" data-toggle="tab">{{ __('user/profile.overview') }}</a>
                    </li>

                    @can('update-profile', $user)
                        <li>
                            <a href="{{ route('account.profile.edit') }}">{{ __('user/profile.edit_account') }}</a>
                        </li>
                    @endcan

                    @can('update-password', $user)
                        <li>
                            <a href="{{ route('account.password.index') }}">{{ __('user/profile.change_password') }}</a>
                        </li>
                    @endcan
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="overview">
                        @include('profile._overview')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
