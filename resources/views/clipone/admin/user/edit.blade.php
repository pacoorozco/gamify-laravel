@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ trans('admin/user/title.user_update') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    <h1>
        {{ trans('admin/user/title.user_update') }}
        <small>{{{ $user->username }}}</small>
    </h1>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <i class="clip-users"></i>
        <a href="{{ URL::route('admin.users.index') }}">
            {{ trans('admin/site.users') }}
        </a>
    </li>
    <li class="active">
        {{ trans('admin/user/title.user_update') }}
    </li>
    @endsection

    {{-- Content --}}
    @section('content')

            <!-- Notifications -->
    @include('admin.partials.notifications')
            <!-- ./ notifications -->

    @include('admin/user/_form', ['action' => 'update'])

@endsection