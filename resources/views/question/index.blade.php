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

            <!-- available-questions -->
            <div class="list-group">
                @forelse($questions as $question)
                    <a href="{{ route('questions.show', ['q_hash' => $question->hash, 'slug' => $question->slug]) }}" class="list-group-item">
                        <h4 class="list-group-item-heading">{{ $question->name }}</h4>
                        <p class="list-group-item-text"></p>
                    </a>
                @empty
                    @include('question/_empty-list')
                @endforelse
            </div>
            <!-- ./available-questions -->

        </div>
        <!-- ./box-body -->

        <!-- pagination-links -->
        <div class="box-footer clearfix">
            {{ $questions->links('partials.simple-pager') }}
        </div>
        <!-- ./pagination-links -->
    </div>
@endsection
