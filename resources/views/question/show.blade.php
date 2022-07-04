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
    <li>
        <a href="{{ route('home') }}">
            <i class="fa fa-dashboard"></i> {{ __('site.home') }}
        </a>
    </li>
    <li>
        <a href="{{ route('questions.index') }}">
            {{ __('site.play') }}
        </a>
    </li>
    <li class="active">
        {{ $question->name }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    @include('partials.notifications')

    @includeUnless(is_null($response), 'question._show_question_answer')

    @includeWhen(is_null($response), 'question._show_question_form')

@endsection
