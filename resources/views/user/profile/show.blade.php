@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
	{{{ $title }}} :: @parent
@stop

{{-- Content Header --}}
@section('header')
<h1>
    {{{ $title }}} <small>{{ $user->fullname }}</small>
</h1>
@stop

{{-- Breadcrumbs --}}
@section('breadcrumbs')
<li>
    <i class="clip-home-3"></i>
    <a href="{{ URL::route('home') }}">
        {{ trans('site.home') }}
    </a>
</li>
<li class="active">
    {{ $title }}
</li>
@stop

{{-- Content --}}
@section('content')

<!-- Notifications -->
@include('notifications')
<!-- ./ notifications -->

@include('user/profile/_details', compact('user'))

@stop