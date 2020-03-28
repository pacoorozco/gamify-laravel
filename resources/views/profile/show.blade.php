@extends('layouts.master')

{{-- Web site Title --}}
@section('title', __('user/profile.title'))

{{-- Content Header --}}
@section('header', __('user/profile.title'))

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('home') }}">
            <i class="fa fa-dashboard"></i> @lang('site.home')
        </a>
    </li>
    <li class="active">
        @lang('user/profile.title')
    </li>
@endsection

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-md-4">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive" src="{{ $user->profile->avatar }}"
                         alt="User profile picture">

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    <p class="text-muted text-center">{{ $user->level }}</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <strong>@lang('user/profile.experience')</strong> <a class="pull-right">{{ $user->experience }}</a>
                        </li>
                        <li class="list-group-item">
                            <strong>Questions</strong> <a class="pull-right">{{ count($user->answeredQuestions) }}</a>
                        </li>
                        <li class="list-group-item">
                            <strong>Badges</strong> <a class="pull-right">{{ count($user->getCompletedBadges()) }}</a>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.profile image -->

            <!-- About Me -->
            @include('profile._about_me')
            <!-- /.about me -->

        </div>
        <div class="col-md-8">
            <!-- notifications -->
            @include('partials.notifications')
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#overview" data-toggle="tab">@lang('user/profile.overview')</a>
                    </li>
                    {{--
                    <li>
                        <a href="#timeline" data-toggle="tab">Timeline</a>
                    </li>
                    --}}
                    @if ($user->username == Auth::user()->username)
                    <li>
                        <a href="#settings" data-toggle="tab">@lang('user/profile.edit_account')</a>
                    </li>
                    @endif
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="overview">
                        @include('profile._overview')
                    </div>
                    {{--
                    <div class="tab-pane" id="timeline">
                        @include('profile._timeline')
                    </div>
                    --}}
                    @if ($user->username == Auth::user()->username)
                    <div class="tab-pane" id="settings">
                        @include('profile._settings')
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
