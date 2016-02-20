@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ trans('admin/user/title.user_delete') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    {{ trans('admin/user/title.user_delete') }}
    <small>{{ $user->username }}</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.users.index') }}">
            <i class="fa fa-users"></i> {{ trans('admin/site.users') }}
        </a>
    </li>
    <li class="active">
        {{ trans('admin/user/title.user_delete') }}
    </li>
    @endsection

    {{-- Content --}}
    @section('content')

            <!-- Notifications -->
    @include('partials.notifications')
            <!-- ./ notifications -->

    {{-- Delete User Form --}}
    {!! Form::open(array('route' => array('admin.users.destroy', $user), 'method' => 'delete', )) !!}
    @include('admin/user/_details', ['action' => 'delete'])
    {!! Form::close() !!}

@endsection