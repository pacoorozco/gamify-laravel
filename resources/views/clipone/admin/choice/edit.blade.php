@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
	{{{ $title }}} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
<h1>
    {{{ $title }}} <small>{{{ $question->name }}}</small>
</h1>
@endsection

{{-- Content --}}
@section('content')

<!-- Notifications -->
@include('notifications')
<!-- ./ notifications -->

@include('admin/choice/_form', compact('question', 'choice'))

@endsection