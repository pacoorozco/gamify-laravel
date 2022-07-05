@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/site.dashboard'))

{{-- Content Header --}}
@section('header', __('admin/site.dashboard'))

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li class="active">
        <i class="fa fa-dashboard"></i> {{ __('admin/site.dashboard') }}
    </li>
@endsection

@section('content')
    <!-- info boxes -->
    <div class="row">
        @include('admin.dashboard._info_boxes')
    </div>
    <!-- ./info boxes -->

    <div class="row">
        <div class="col-md-6">
            @include('admin.dashboard._latest_published_questions')
        </div>
        <div class="col-md-6">
            @include('admin.dashboard._latest_registered_users')
        </div>

    </div>


@endsection
