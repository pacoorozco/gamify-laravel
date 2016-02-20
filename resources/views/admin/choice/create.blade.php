@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ trans('admin/choice/title.create_new') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
        {{ $question->name }}
        <small>{{ trans('admin/choice/title.create_new') }}</small>
@endsection


    {{-- Content --}}
    @section('content')

            <!-- Notifications -->
    @include('partials.notifications')
            <!-- ./ notifications -->

    @include('admin/choice/_form')

@endsection