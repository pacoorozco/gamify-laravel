@extends('layouts.master')

{{-- Web site Title --}}
@section('title', __('site.play'))

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

            <!-- user metrics -->
            <div class="row">
                <div class="col-md-6">
                    @include('question/_answered_questions_box', [
                    'answered_questions' => $answered_questions,
                    'percentage_of_answered_questions' => $percentage_of_answered_questions,
                    ])
                </div>
                <div class="col-md-6">
                    @include('question/_next_level_box', [
                    'next_level_name' => $next_level_name,
                    'percentage_to_next_level' => $percentage_to_next_level,
                    'points_to_next_level' => $points_to_next_level,
                    ])
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
