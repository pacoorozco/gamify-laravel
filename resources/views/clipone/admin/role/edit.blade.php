@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
	{{{ $title }}} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
<h1>
    {{{ $title }}} <small>{{{ $role->name }}}</small>
</h1>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
<li>
    <i class="clip-bubbles-3"></i>
    <a href="{{ URL::route('admin.roles.index') }}">
        {{ trans('admin/site.roles') }}
    </a>
</li>
<li class="active">
    {{ trans('admin/role/title.edit') }}
</li>
@endsection

{{-- Content --}}
@section('content')

<!-- Notifications -->
@include('notifications')
<!-- ./ notifications -->

@include('admin/role/_form', compact('role', 'permissions'))
@endsection
