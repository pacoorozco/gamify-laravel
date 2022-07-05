@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ __('admin/user/title.create_a_new_user') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    {{ __('admin/user/title.create_a_new_user') }}
    <small>add a new user</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li>
        <a href="{{ route('admin.users.index') }}">
            {{ __('admin/site.users') }}
        </a>
    </li>
    <li class="active">
        {{ __('admin/user/title.create_a_new_user') }}
    </li>
    @endsection


    {{-- Content --}}
    @section('content')

            <!-- Notifications -->
    @include('partials.notifications')
            <!-- ./ notifications -->

    @include('admin/user/_form', ['action' => 'create'])

@endsection
