@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ trans('admin/badge/title.create_a_new_badge') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    <h1>
        {{ trans('admin/badge/title.create_a_new_badge') }}
        <small>create a new badge</small>
    </h1>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <i class="fa fa-gift"></i>
        <a href="{{ route('admin.badges.index') }}">
            {{ trans('admin/site.badges') }}
        </a>
    </li>
    <li class="active">
        {{ trans('admin/badge/title.create_a_new_badge') }}
    </li>
    @endsection

    {{-- Content --}}
    @section('content')

            <!-- Notifications -->
    @include('partials.notifications')
            <!-- ./ notifications -->

    @include('admin/badge/_form')

@endsection
