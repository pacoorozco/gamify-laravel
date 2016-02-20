@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ trans('admin/question/title.question_edit') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
        {{ trans('admin/question/title.question_edit') }}
        <small>{{ $question->name }}</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.questions.index') }}">
            <i class="fa fa-comments"></i> {{ trans('admin/site.questions') }}
        </a>
    </li>
    <li class="active">
        {{ trans('admin/question/title.question_edit') }}
    </li>
    @endsection

    {{-- Content --}}
    @section('content')

            <!-- Notifications -->
    @include('partials.notifications')
            <!-- ./ notifications -->

    @include('admin/question/_form')
@endsection