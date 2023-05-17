@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/level/title.level_update'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/level/title.level_update') }}
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
        {{ __('admin/level/title.level_edit') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    {{ Form::model($level, [
            'route' => ['admin.levels.update', $level],
            'method' => 'put',
            'files' => true,
            ]) }}


    <div class="box box-solid">
        <div class="box-header with-border">
            <h2 class="box-title">
                {{ $level->present()->nameWithStatusBadge() }}
            </h2>
        </div>
        <div class="box-body">
            <div class="row">

                <!-- right column -->
                <div class="col-md-6">
                    <!-- name -->
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        {{ Form::label('name', __('admin/level/model.name'),['class' => 'control-label required']) }}
                        <div class="controls">
                            {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) }}
                            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                        </div>
                    </div>
                    <!-- ./ name -->

                    <!-- required_points -->
                    <div class="form-group {{ $errors->has('required_points') ? 'has-error' : '' }}">
                        {{ Form::label('required_points', __('admin/level/model.required_points'), ['class' => 'control-label required']) }}
                        <div class="controls">
                            {{ Form::number('required_points', null, array('class' => 'form-control', 'required' => 'required', 'min' => '0')) }}
                            <span class="help-block">{{ $errors->first('required_points', ':message') }}</span>
                        </div>
                    </div>
                    <!-- ./ required_points -->

                    <!-- activation status -->
                    <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">
                        {{ Form::label('active', __('admin/level/model.active'), array('class' => 'control-label required')) }}
                        <div class="controls">
                            {{ Form::select('active', array('1' => __('general.yes'), '0' => trans('general.no')), null, array('class' => 'form-control', 'required' => 'required')) }}
                            {{ $errors->first('active', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>
                    <!-- ./ activation status -->

                </div>
                <!-- ./left column -->

                <!-- right column -->
                <div class="col-md-6">

                    <!-- image -->
                    <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                        {!! Form::label('image', __('admin/level/model.image'), ['class' => 'control-label required']) !!}
                        <p class="text-muted">{{ __('admin/level/model.image_help') }}</p>
                        <div class="controls">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                     style="width: 150px; height: 150px;">
                                    {{ $level->present()->imageTag() }}
                                </div>
                                <p>
                             <span class="btn btn-default btn-file">
                                <span class="fileinput-new">
                                    <i class="fa fa-picture-o"></i> {{ __('button.pick_image') }}
                                </span>
                                <span class="fileinput-exists">
                                    <i class="fa fa-picture-o"></i> {{ __('button.upload_image') }}
                                </span>
                                {!! Form::file('image') !!}
                            </span>
                                    <a href="#" class="btn fileinput-exists btn-default" data-dismiss="fileinput">
                                        <i class="fa fa-times"></i> {{ __('button.delete_image') }}
                                    </a>
                                </p>
                            </div>
                        </div>
                        <span class="help-block">{{ $errors->first('image', ':message') }}</span>
                    </div>
                    <!-- ./ image -->

                    <!-- danger zone -->
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <strong>@lang('admin/level/messages.danger_zone_section')</strong>
                        </div>
                        <div class="panel-body">
                            <p><strong>@lang('admin/level/messages.delete_button')</strong></p>
                            <p>@lang('admin/level/messages.delete_help')</p>

                            <div class="text-center">
                                <button type="button" class="btn btn-danger"
                                        data-toggle="modal"
                                        data-target="#confirmationModal">
                                    @lang('admin/level/messages.delete_button')
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- ./danger zone -->

                </div>
                <!-- ./right column -->

            </div>
        </div>

        <div class="box-footer">
            <!-- Form Actions -->
            {{ Form::button(__('button.save'), ['type' => 'submit', 'class' => 'btn btn-success']) }}
            <a href="{{ route('admin.levels.index') }}" class="btn btn-link" role="button">
                {{ __('general.back') }}
            </a>
            <!-- ./ form actions -->
        </div>

    </div>
    {{ Form::close() }}

    <!-- confirmation modal -->
    <x-modals.confirmation
        action="{{ route('admin.levels.destroy', $level) }}"
        confirmationText="{{ $level->name }}"
        buttonText="{{ __('admin/level/messages.delete_confirmation_button') }}">

        <div class="alert alert-warning" role="alert">
            @lang('admin/level/messages.delete_confirmation_warning', ['name' => $level->name])
        </div>
    </x-modals.confirmation>
    <!-- ./ confirmation modal -->
@endsection

{{-- Styles --}}
@push('styles')
    <!-- File Input -->
    <link rel="stylesheet" href="{{ asset('vendor/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
@endpush

{{-- Scripts --}}
@push('scripts')
    <!-- File Input -->
    <script type="text/javascript" src="{{ asset('vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
@endpush


