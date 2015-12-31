@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ trans('admin/question/title.question_update') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    <h1>
        {{ trans('admin/question/title.question_update') }}
        <small>{{ $question->name }}</small>
    </h1>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <i class="clip-bubbles-3"></i>
        <a href="{{ route('admin.questions.index') }}">
            {{ trans('admin/site.questions') }}
        </a>
    </li>
    <li class="active">
        {{ trans('admin/question/title.edit') }}
    </li>
    @endsection

    {{-- Content --}}
    @section('content')

            <!-- Notifications -->
    @include('partials.notifications')
            <!-- ./ notifications -->

    @include('admin/question/_form')
@endsection