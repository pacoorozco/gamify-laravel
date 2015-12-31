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

{{-- Breadcrumbs --}}
@section('breadcrumbs')
<li>
    <i class="clip-bubbles-3"></i>
    <a href="{{ URL::route('admin.questions.index') }}">
        {{ trans('admin/site.questions') }}
    </a>
</li>
<li class="active">
    {{ trans('admin/question/title.edit') }}
</li>
@endsection

{{-- Content --}}
@section('content')

<!-- Notifications -->
@include('notifications')
<!-- ./ notifications -->

@include('admin/question/_form', compact('question'))
@endsection