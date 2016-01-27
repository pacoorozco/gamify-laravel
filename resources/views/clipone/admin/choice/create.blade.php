@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ trans('admin/question/title.question_show') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    <h1>
        {{ $question->name }}
        <small>add a answer choice</small>
    </h1>
    @endsection


    {{-- Content --}}
    @section('content')

            <!-- Notifications -->
    @include('partials.notifications')
            <!-- ./ notifications -->

    @include('admin/choice/_form')

@endsection