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
        <section class="col-md-6 connectedSortable ui-sortable">

                @include('admin.dashboard._latest_published_questions')

                @include('admin.dashboard._next_scheduled_questions')

        </section>

        <section class="col-md-6 connectedSortable ui-sortable">

            @include('admin.dashboard._latest_registered_users')

        </section>
    </div>


@endsection
