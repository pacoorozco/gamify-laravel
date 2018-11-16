@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ trans('admin/reward/messages.title') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    {{ trans('admin/reward/messages.title') }}
    <small>{{ trans('admin/reward/messages.header') }}</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin-home') }}">
            <i class="fa fa-dashboard"></i> {{ trans('admin/site.dashboard') }}
        </a>
    </li>
    <li class="active">
        {{ trans('admin/site.rewards') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

            <!-- notifications -->
    @include('partials.notifications')
            <!-- ./ notifications -->

    <div class="row">
        <div class="col-xs-6">
            @include('admin/reward/_form_experience')
        </div>
        <div class="col-xs-6">
            @include('admin/reward/_form_badge')
        </div>
    </div>
@endsection

{{-- Styles --}}
@section('styles')
            <!-- Select2 -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}">
@endsection

{{-- Scripts --}}
@section('scripts')
            <!-- Select2 -->
    <script type="text/javascript" src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
    <script>
        $(function () {
            $(".username-input").select2({
                theme: "bootstrap",
                placeholder: "{{ trans('admin/reward/messages.pick_user') }}",
            });
            $(".badge-input").select2({
                theme: "bootstrap",
                placeholder: "{{ trans('admin/reward/messages.pick_badge') }}",
            });
        });
    </script>
@endsection
