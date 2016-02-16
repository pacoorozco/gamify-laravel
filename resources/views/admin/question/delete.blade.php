@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ trans('admin/question/title.question_delete') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    <h1>
        {{ trans('admin/question/title.question_delete') }}
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
        {{ trans('admin/question/title.question_delete') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

            <!-- Notifications -->
    @include('admin.partials.notifications')
            <!-- ./ notifications -->

    {{-- Delete Question Form --}}
    {!! Form::open(array('route' => array('admin.questions.destroy', $question), 'method' => 'delete', )) !!}
    @include('admin/question/_details', ['action' => 'delete'])
    {!! Form::close() !!}
@endsection