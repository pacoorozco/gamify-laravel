@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    @lang('admin/reward/messages.title') :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    @lang('admin/reward/messages.title')
    <small>@lang('admin/reward/messages.header')</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> @lang('admin/site.dashboard')
        </a>
    </li>
    <li class="active">
        @lang('admin/site.rewards')
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
@push('styles')
    <!-- Select2 -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/AdminLTE/plugins/select2/css/select2.min.css') }}">
@endpush

{{-- Scripts --}}
@push('scripts')
    <!-- Select2 -->
    <script type="text/javascript" src="{{ asset('vendor/AdminLTE/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $(".username-input").select2({
                placeholder: "@lang('admin/reward/messages.pick_user')",
            });
            $(".badge-input").select2({
                placeholder: "@lang('admin/reward/messages.pick_badge')",
            });
        });
    </script>
@endpush
