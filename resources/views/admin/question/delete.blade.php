@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    @lang('admin/question/title.question_delete') :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    @lang('admin/question/title.question_delete')
    <small>{{ $question->name }}</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> @lang('admin/site.dashboard')
        </a>
    </li>
    <li>
        <a href="{{ route('admin.questions.index') }}">
            @lang('admin/site.questions')
        </a>
    </li>
    <li class="active">
        @lang('admin/question/title.question_delete')
    </li>
    @endsection

    {{-- Content --}}
    @section('content')

            <!-- Notifications -->
    @include('partials.notifications')
            <!-- ./ notifications -->

    {{-- Delete Question Form --}}
    {!! Form::open(array('route' => array('admin.questions.destroy', $question), 'method' => 'delete', )) !!}
    @include('admin/question/_details', ['action' => 'delete'])
    {!! Form::close() !!}
@endsection
