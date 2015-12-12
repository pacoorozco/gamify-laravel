@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
	{{{ $title }}} :: @parent
@stop

{{-- Content Header --}}
@section('header')
<h1>
    {{{ $title }}} <small>add a new user</small>
</h1>
@stop

{{-- Breadcrumbs --}}
@section('breadcrumbs')
<li>
    <i class="clip-bubbles-3"></i>
    <a href="{{ URL::route('admin.users.index') }}">
        {{ trans('admin/site.users') }}
    </a>
</li>
<li class="active">
    {{ trans('admin/user/title.create_a_new_user') }}
</li>
@stop


{{-- Content --}}
@section('content')

<!-- Notifications -->
@include('notifications')
<!-- ./ notifications -->

@include('admin/user/_form', compact('roles', 'selectedRoles'))

@stop