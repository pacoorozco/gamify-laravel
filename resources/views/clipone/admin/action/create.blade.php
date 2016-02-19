@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ trans('admin/question/title.question_show') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    <h1>
        {{ $question->name }}
        <small>add a answer action</small>
    </h1>
    @endsection


    {{-- Content --}}
    @section('content')

            <!-- Notifications -->
    @include('admin.partials.notifications')
            <!-- ./ notifications -->

    @include('clipone.admin.action._form')

@endsection