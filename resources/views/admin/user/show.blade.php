@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    @lang('admin/user/title.user_show') :: @parent
@endsection

{{-- Content Header --}}
@section('header')
        @lang('admin/user/title.user_show')
        <small>{{ $user->username }}</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> @lang('admin/site.dashboard')
        </a>
    </li>
    <li>
        <a href="{{ route('admin.users.index') }}">
            @lang('admin/site.users')
        </a>
    </li>
    <li class="active">
        @lang('admin/user/title.user_show')
    </li>
    @endsection

    {{-- Content --}}
    @section('content')

            <!-- Notifications -->
    @include('partials.notifications')
            <!-- ./ notifications -->

    @include('admin/user/_details', ['action' => 'show'])

@endsection
