@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/level/title.level_delete'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/level/title.level_delete') }}
    <small>{{ $level->name }}</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li>
        <a href="{{ route('admin.levels.index') }}">
            {{ __('admin/site.levels') }}
        </a>
    </li>
    <li class="active">
        {{ __('admin/level/title.level_delete') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    {{-- Delete Level Form --}}
    {!! Form::open(['route' => ['admin.levels.destroy', $level], 'method' => 'delete']) !!}
    @include('admin/level/_details', ['action' => 'delete'])
    {!! Form::close() !!}

@endsection
