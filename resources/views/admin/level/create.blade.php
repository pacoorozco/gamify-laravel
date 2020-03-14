@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    @lang('admin/level/title.create_a_new_level') :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    @lang('admin/level/title.create_a_new_level')
    <small>create a new level</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> @lang('admin/site.dashboard')
        </a>
    </li>
    <li>
        <a href="{{ route('admin.levels.index') }}">
            @lang('admin/site.levels')
        </a>
    </li>
    <li class="active">
        @lang('admin/level/title.create_a_new_level')
    </li>
    @endsection

    {{-- Content --}}
    @section('content')

            <!-- Notifications -->
    @include('partials.notifications')
            <!-- ./ notifications -->

    @include('admin/level/_form')

@endsection
