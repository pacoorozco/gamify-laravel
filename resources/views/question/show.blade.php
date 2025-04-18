@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
    {{ __('site.play') }} :: {{ $question->name }} @parent
@endsection

{{-- Content Header --}}
@section('header')
    {{ __('site.play') }}
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">
            {{ __('site.home') }}
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('questions.index') }}">
            {{ __('site.play') }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        {{ $question->name }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- notifications -->
    @include('partials.notifications')
    <!-- /.notifications -->

    @includeUnless(is_null($response), 'question._show_question_answer')

    @includeWhen(is_null($response), 'question._show_question_form')

@endsection
