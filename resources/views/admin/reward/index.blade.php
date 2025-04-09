@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ __('admin/reward/messages.title') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    {{ __('admin/reward/messages.title') }}
    <small class="text-muted">{{ __('admin/reward/messages.header') }}</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.home') }}">
            {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        {{ __('admin/site.rewards') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    <div class="row">
        <div class="col-md-6">
            @include('admin/reward/_form_experience')
        </div>
        <div class="col-md-6">
            @include('admin/reward/_form_badge')
        </div>
    </div>
@endsection

{{-- Styles --}}
@push('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('vendor/AdminLTE/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/AdminLTE/plugins/select2/select2-bootstrap4.min.css') }}">
@endpush

{{-- Scripts --}}
@push('scripts')
    <!-- Select2 -->
    <script src="{{ asset('vendor/AdminLTE/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $(".username-input").select2({
                theme: 'bootstrap4',
                placeholder: "{{ __('admin/reward/messages.pick_user') }}",
            });
            $(".badge-input").select2({
                theme: 'bootstrap4',
                placeholder: "{{ __('admin/reward/messages.pick_badge') }}",
            });
        });
    </script>
@endpush
