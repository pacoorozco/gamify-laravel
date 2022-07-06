@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/question/title.question_show'))

{{-- Content Header --}}
@section('header', __('admin/question/title.question_show'))

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li>
        <a href="{{ route('admin.questions.index') }}">
            {{ __('admin/site.questions') }}
        </a>
    </li>
    <li class="active">
        {{ __('admin/question/title.question_show') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- /.notifications -->

    @include('admin/question/_details', ['action' => 'show'])

@endsection
