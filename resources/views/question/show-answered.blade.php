@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
    {{ trans('site.play') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    {{ trans('site.play') }}
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('home') }}">
            <i class="fa fa-dashboard"></i> {{ trans('site.home') }}
        </a>
    </li>
    <li>
        <a href="{{ route('questions.index') }}">
            {{ trans('site.play') }}
        </a>
    </li>
    <li class="active">
        {{ $question->name }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    @include('partials.notifications')

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $question->name }}</h3>
        </div>
        <div class="box-body">
            {!! $question->question !!}

            @if($question->solution)
                <div class="callout callout-success">
                    <h4>{{ trans('question/messages.explained_answer') }}</h4>
                    {!! $question->solution !!}
                </div>
            @endif

            <h4>
                @if($question->type == 'single')
                    {{ trans('question/messages.single_choice') }}
                @else
                    {{ trans('question/messages.multiple_choices') }}
                @endif
            </h4>

            <ul class="list-group">
                @foreach($question->choices as $choice)
                    <li class="list-group-item">
                        @if($choice->correct)
                            <span class="glyphicon glyphicon-ok"></span>
                        @else
                            <span class="glyphicon glyphicon-remove"></span>
                        @endif

                        @if($choice->points > 0)
                            <span class="label label-success pull-right">
                                {{ trans('question/messages.choice_score', ['points' => $choice->points]) }}
                            </span>
                        @else
                            <span class="label label-danger pull-right">
                                {{ trans('question/messages.choice_score', ['points' => $choice->points]) }}
                            </span>
                        @endif
                        {{ $choice->text }}
                    </li>
                @endforeach
            </ul>

            <div class="callout callout-info">
                {!! trans('question/messages.obtained_points', ['points' => $answer->pivot->points]) !!}
            </div>
        </div>
    </div>
@endsection
