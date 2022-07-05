@extends('layouts.master')

{{-- Web site Title --}}
@section('title', __('site.play'))

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

            <!-- user metrics -->
            <div class="row">
                <div class="col-md-6">
                    @include('question/_answered_questions_box')
                </div>
                <div class="col-md-6">
                    @include('question/_next_level_box')
                </div>
            </div>
            <!-- ./user metrics -->

            <ul class="list-group">
                @forelse($questions as $question)
                    <li class="list-group-item"><a
                            href="{{ $question->present()->publicUrl }}">{{ $question->name }}</a></li>
                @empty
                    @include('question/_empty-list')
                @endforelse
            </ul>
        </div>
        <!-- /.box-body -->
    </div>
@endsection
