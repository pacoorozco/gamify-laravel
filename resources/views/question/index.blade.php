@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
    @lang('site.play') :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    @lang('site.play')
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('home') }}">
            <i class="fa fa-dashboard"></i> @lang('site.home')
        </a>
    </li>
    <li class="active">
        @lang('site.play')
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
