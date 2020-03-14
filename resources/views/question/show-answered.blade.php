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
    <li>
        <a href="{{ route('questions.index') }}">
            @lang('site.play')
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
                    <h4>@lang('question/messages.explained_answer')</h4>
                    {!! $question->solution !!}
                </div>
            @endif

            <h4>
                @if($question->type == 'single')
                    @lang('question/messages.single_choice')
                @else
                    @lang('question/messages.multiple_choices')
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
                                {{ __('question/messages.choice_score', ['points' => $choice->score]) }}
                            </span>
                        @else
                            <span class="label label-danger pull-right">
                                {{ __('question/messages.choice_score', ['points' => $choice->score]) }}
                            </span>
                        @endif
                        {{ $choice->text }}
                    </li>
                @endforeach
            </ul>

            <div class="callout callout-info">
                {!! __('question/messages.obtained_points', ['points' => $answer->pivot->points]) !!}
            </div>
        </div>
    </div>
@endsection
