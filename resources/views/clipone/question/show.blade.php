@extends('layouts.master')

{{-- Content --}}
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>{{ $question->name }}</h2>
        </div>
        <div class="panel-body">
            <h4>{!! $question->question !!}</h4>
            {!! Form::open(array('route' => ['questions.store', $question->shortname])) !!}
            <ul class="list-group">
                @foreach($question->choices as $choice)
                    <li class="list-group-item">
                        @if($question->type == 'single')
                            <label>{!! Form::radio('choices[]', $choice->id,  null) !!} {{ $choice->text }}</label>
                        @else
                            <label>{!! Form::checkbox('choices[]', $choice->id,  null) !!} {{ $choice->text }}</label>
                        @endif
                    </li>
                @endforeach
            </ul>
            {!! Form::submit('Enviar') !!}
            {!! Form::close() !!}
        </div>
    </div>

@endsection