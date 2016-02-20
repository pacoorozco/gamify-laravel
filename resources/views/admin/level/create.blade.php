@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ trans('admin/level/title.create_a_new_level') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    {{ trans('admin/level/title.create_a_new_level') }}
    <small>create a new level</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.levels.index') }}">
            <i class="fa fa-graduation-cap"></i> {{ trans('admin/site.levels') }}
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