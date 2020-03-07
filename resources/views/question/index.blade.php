@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
    {{ __('site.play') }} :: @parent
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
    <li class="active">
        {{ __('site.play') }}
    </li>
@endsection

{{-- Content --}}
@section('content')
    <div class="box box-default">
        <div class="box-body">
            <ul class="list-group">
                @foreach($questions as $question)
                    <li class="list-group-item"><a href="{{ route('questions.show', $question->short_name) }}">{{ $question->name }}</a></li>
                @endforeach
            </ul>
        </div>
        <!-- /.box-body -->
    </div>
@endsection
