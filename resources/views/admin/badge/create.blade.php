@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    @lang('admin/badge/title.create_a_new_badge') :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    @lang('admin/badge/title.create_a_new_badge')
    <small>create a new badge</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> @lang('admin/site.dashboard')
        </a>
    </li>
    <li>
        <a href="{{ route('admin.badges.index') }}">
            @lang('admin/site.badges')
        </a>
    </li>
    <li class="active">
        @lang('admin/badge/title.create_a_new_badge')
    </li>
    @endsection

    {{-- Content --}}
    @section('content')

            <!-- Notifications -->
    @include('partials.notifications')
            <!-- ./ notifications -->

    @include('admin/badge/_form')

@endsection
