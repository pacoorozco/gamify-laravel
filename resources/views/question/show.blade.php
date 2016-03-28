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



    {!! Form::open(array('route' => ['questions.answer', $question->shortname])) !!}
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $question->name }}</h3>
        </div>
        <div class="box-body">
            {!! $question->question !!}

                @foreach($question->choices as $choice)
                <div class="form-group">
                    @if($question->type == 'single')
                        <label>{!! Form::radio('choices[]', $choice->id,  null) !!} {{ $choice->text }}</label>
                    @else
                        <label>{!! Form::checkbox('choices[]', $choice->id,  null) !!} {{ $choice->text }}</label>
                    @endif
                </div>
                @endforeach

        </div>
        <div class="box-footer">
            {!! Form::submit('Enviar', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}

@endsection