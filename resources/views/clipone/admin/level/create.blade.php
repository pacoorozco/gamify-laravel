@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ trans('admin/level/title.create_a_new_level') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    <h1>
        {{ trans('admin/level/title.create_a_new_level') }}
        <small>create a new level</small>
    </h1>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <i class="fa fa-graduation-cap"></i>
        <a href="{{ route('admin.levels.index') }}">
            {{ trans('admin/site.levels') }}
        </a>
    </li>
    <li class="active">
        {{ trans('admin/level/title.create_a_new_level') }}
    </li>
    @endsection

    {{-- Content --}}
    @section('content')

            <!-- Notifications -->
    @include('partials.notifications')
            <!-- ./ notifications -->

    @include('admin/level/_form')

@endsection