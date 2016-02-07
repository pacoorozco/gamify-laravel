@extends('layouts.master')

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h1>Participa</h1>
    </div>
    <ul>
        @foreach($questions as $question)
            <li><a href="{{ route('questions.show', $question->shortname) }}">{{ $question->name }}</a></li>
        @endforeach
    </ul>
@endsection