@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ __('admin/question/title.question_show') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
        {{ $question->name }}
        <small>add a answer action</small>
    @endsection


    {{-- Content --}}
    @section('content')

            <!-- Notifications -->
    @include('partials.notifications')
            <!-- ./ notifications -->

    @include('admin.action._form')

@endsection
