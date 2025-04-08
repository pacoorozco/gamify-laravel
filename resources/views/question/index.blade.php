@extends('layouts.master')

{{-- Web site Title --}}
@section('title', __('site.play'))

{{-- Content Header --}}
@section('header')
    {{ __('site.play') }}
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">
            {{ __('site.home') }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        {{ __('site.play') }}
    </li>
@endsection

{{-- Content --}}
@section('content')
    <div class="card">
        <div class="card-body">

            <!-- user metrics -->
            <div class="row row-cols-1 row-cols-md-2">
                <div class="col">
                    @include('question/_answered_questions_box')
                </div>
                <div class="col">
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
        <div class="card-footer">
            {{ $questions->links('partials.simple-pager') }}
        </div>
        <!-- ./pagination-links -->
    </div>
@endsection
