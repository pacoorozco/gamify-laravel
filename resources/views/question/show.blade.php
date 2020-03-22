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



    {!! Form::open(array('route' => ['questions.answer', $question->short_name])) !!}
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $question->name }}</h3>
        </div>
        <div class="box-body">
            {!! $question->question !!}

            <fieldset>
                <h4>@lang('question/messages.choices')</h4>
                @foreach($question->choices as $choice)
                    <div class="form-group">
                        @if($question->type == 'single')
                            <label>{!! Form::radio('choices[]', $choice->id,  false, ['required' => 'required']) !!} {{ $choice->text }}</label>
                        @else
                            <label>{!! Form::checkbox('choices[]', $choice->id,  false, ['required' => 'required']) !!} {{ $choice->text }}</label>
                        @endif
                    </div>
                @endforeach
            </fieldset>

        </div>
        <div class="box-footer">
            {!! Form::submit(__('question/messages.send'), ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection
