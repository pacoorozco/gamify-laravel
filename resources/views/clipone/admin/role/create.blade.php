@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
	{{{ $title }}} :: @parent
@stop

{{-- Content Header --}}
@section('header')
<h1>
    {{{ $title }}} <small>create a new role</small>
</h1>
@stop

{{-- Breadcrumbs --}}
@section('breadcrumbs')
<li>
    <i class="clip-bubbles-3"></i>
    <a href="{{ URL::route('admin.roles.index') }}">
        {{ trans('admin/site.roles') }}
    </a>
</li>
<li class="active">
    {{ trans('admin/role/title.create_a_new_role') }}
</li>
@stop


{{-- Content --}}
@section('content')

<!-- notifications -->
@include('notifications')
<!-- ./ notifications -->

@include('admin/role/_form', compact('permissions', 'selectedPermissions'))
@stop
