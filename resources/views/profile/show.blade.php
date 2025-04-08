@extends('layouts.master')

{{-- Web site Title --}}
@section('title', __('user/profile.title'))

{{-- Content Header --}}
@section('header', __('user/profile.title'))

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">
            {{ __('site.home') }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        {{ __('user/profile.title') }}
    </li>
@endsection

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-md-4">

            <!-- Profile Image -->
            <div class="card card-widget widget-user">
                <div class="widget-user-header bg-aqua-active">
                    <h3 class="widget-user-username">{{ $user->name }}</h3>
                    <h5 class="widget-user-desc">{{ $user->level }}</h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle elevation-2" src="{{ $user->profile->avatarUrl }}" alt="User Avatar">
                </div>
                <div class="card-footer">
                    <div class="row row-cols-1 row-cols-md-3">
                        <div class="col border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{ $user->experience }}</h5>
                                <span class="description-text">XP</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{ $user->answeredQuestionsCount() }}</h5>
                                <span class="description-text">ANSWERS</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col">
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
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a href="#overview" data-toggle="tab" class="nav-link active">{{ __('user/profile.overview') }}</a>
                        </li>

                        @can('update-profile', $user)
                            <li class="nav-item">
                                <a href="{{ route('account.profile.edit') }}" class="nav-link">{{ __('user/profile.edit_account') }}</a>
                            </li>
                        @endcan

                        @can('update-password', $user)
                            <li class="nav-item">
                                <a href="{{ route('account.password.index') }}" class="nav-link">{{ __('user/profile.change_password') }}</a>
                            </li>
                        @endcan
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="overview">
                            @include('profile._overview')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
