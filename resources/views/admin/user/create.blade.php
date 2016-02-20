@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ trans('admin/user/title.create_a_new_user') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    {{ trans('admin/user/title.create_a_new_user') }}
    <small>add a new user</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.users.index') }}">
            <i class="fa fa-users"></i> {{ trans('admin/site.users') }}
        </a>
    </li>
    <li class="active">
        {{ trans('admin/user/title.create_a_new_user') }}
    </li>
    @endsection


    {{-- Content --}}
    @section('content')

            <!-- Notifications -->
    @include('partials.notifications')
            <!-- ./ notifications -->

    @include('admin/user/_form', ['action' => 'create'])

@endsection