@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ trans('admin/badge/title.badge_delete') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    {{ trans('admin/badge/title.badge_delete') }}
    <small>{{ $badge->name }}</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin-home') }}">
            <i class="fa fa-dashboard"></i> {{ trans('admin/site.dashboard') }}
        </a>
    </li>
    <li>
        <a href="{{ URL::route('admin.badges.index') }}">
            {{ trans('admin/site.badges') }}
        </a>
    </li>
    <li class="active">
        {{ trans('admin/badge/title.badge_delete') }}
    </li>
    @endsection

    {{-- Content --}}
    @section('content')

            <!-- Notifications -->
    @include('partials.notifications')
            <!-- ./ notifications -->

    {{-- Delete Form --}}
    {!! Form::open(array('route' => array('admin.badges.destroy', $badge), 'method' => 'delete', )) !!}
    @include('admin/badge/_details', ['action' => 'delete'])
    {!! Form::close() !!}

@endsection