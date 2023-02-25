@extends('layouts.master')

{{-- Web site Title --}}
@section('title', __('user/profile.edit_account'))

{{-- Content Header --}}
@section('header')
    {{ __('user/profile.edit_account') }}
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('home') }}">
            <i class="fa fa-dashboard"></i> {{ __('site.home') }}
        </a>
    </li>

    <li>
        <a href="{{ route('account.index') }}">
            {{ __('site.my_profile') }}
        </a>
    </li>

    <li class="active">
        {{ __('user/profile.edit_account') }}
    </li>
@endsection

{{-- Content --}}
@section('content')
    <div class="box box-default">
        <div class="box-body">

            <form method="post" action="{{ route('account.profile.update') }}" enctype="multipart/form-data" role="form">
                @csrf
                @method('PUT')

            <div class="row">
                <div class="col-md-6">

                    <!-- username -->
                    <div class="form-group">
                        <label for="username" class="control-label">
                            {{ __('user/profile.username') }}
                        </label>

                        <div class="controls">
                            <input class="form-control" disabled="disabled" name="username" type="text" value="{{ $user->username }}" id="username">
                        </div>
                    </div>
                    <!-- /.username -->

                    <!-- email -->
                    <div class="form-group">
                        <label for="email" class="control-label">
                            {{ __('user/profile.email') }}
                        </label>

                        <div class="controls">
                            <input class="form-control" disabled="disabled" name="email" type="email" value="{{ $user->email }}" id="email">
                        </div>
                    </div>
                    <!-- /.email -->

                    <!-- name -->
                    <div class="form-group">
                        <label for="name" class="control-label">
                            {{ __('user/profile.name') }}
                        </label>

                        <div class="controls">
                            <input class="form-control" name="name" type="text" value="{{ $user->name }}" id="name">
                        </div>
                    </div>
                    <!-- /.name -->

                    <!-- date_of_birth -->
                    <div class="form-group {{ $errors->has('date_of_birth') ? 'has-error' : '' }}">
                        <label for="date_of_birth" class="control-label">
                            {{ __('user/profile.date_of_birth') }}
                        </label>

                        <div class="controls">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input class="form-control date-picker" name="date_of_birth" type="text" value="{{ $user->profile->date_of_birth }}" id="date_of_birth">
                            </div>
                            <span class="help-block">{{ $errors->first('date_of_birth', ':message') }}</span>
                        </div>
                    </div>
                    <!-- /.date_of_birth -->

                </div>
                <div class="col-md-6">

                    <!-- avatar -->
                    <div class="form-group {{ $errors->has('avatar') ? 'has-error' : '' }}">
                        <label for="avatar" class="control-label">
                            {{ __('user/profile.image') }}
                        </label>

                        <div class="controls">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                     style="width: 150px; height: 150px;">
                                    <img src="{{ $user->profile->avatarUrl }}" alt="Avatar">
                                </div>
                                <p>
                    <span class="btn btn-default btn-file">
                        <span class="fileinput-new">
                            <i class="fa fa-picture-o"></i> {{ __('button.pick_image') }}
                        </span>
                        <span class="fileinput-exists">
                            <i class="fa fa-picture-o"></i> {{ __('button.upload_image') }}
                        </span>
                        <input name="avatar" type="file">
                    </span>
                                    <a href="#" class="btn fileinput-exists btn-default" data-dismiss="fileinput">
                                        <i class="fa fa-times"></i> {{ __('button.delete_image') }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- /.avatar -->

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h3>{{ __('user/profile.additional_info') }}</h3>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">

                    <!-- twitter -->
                    <div class="form-group {{ $errors->has('twitter') ? 'has-error' : '' }}">
                        <label for="twitter" class="control-label">
                            {{ __('user/profile.twitter') }}
                        </label>

                        <div class="controls">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
                                <input class="form-control" name="twitter" type="text" value="{{ $user->profile->twitter }}" id="twitter">
                            </div>
                            <span class="help-block">{{ $errors->first('twitter', ':message') }}</span>
                        </div>
                    </div>
                    <!-- /.twitter -->

                    <!-- facebook -->
                    <div class="form-group {{ $errors->has('facebook') ? 'has-error' : '' }}">
                        <label for="facebook" class="control-label">
                            {{ __('user/profile.facebook') }}
                        </label>

                        <div class="controls">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                                <input class="form-control" name="facebook" type="text" value="{{ $user->profile->facebook }}" id="facebook">
                            </div>
                            <span class="help-block">{{ $errors->first('facebook', ':message') }}</span>
                        </div>
                    </div>
                    <!-- /.facebook -->

                </div>
                <div class="col-md-6">

                    <!-- linkedin -->
                    <div class="form-group {{ $errors->has('linkedin') ? 'has-error' : '' }}">
                        <label for="linkedin" class="control-label">
                            {{ __('user/profile.linkedin') }}
                        </label>

                        <div class="controls">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-linkedin"></i></span>
                                <input class="form-control" name="linkedin" type="text" value="{{ $user->profile->linkedin }}" id="linkedin">
                            </div>
                            <span class="help-block">{{ $errors->first('linkedin', ':message') }}</span>
                        </div>
                    </div>
                    <!-- /.linkedin -->

                    <!-- github -->
                    <div class="form-group {{ $errors->has('github') ? 'has-error' : '' }}">
                        <label for="github" class="control-label">
                            {{ __('user/profile.github') }}
                        </label>

                        <div class="controls">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-github"></i></span>
                                <input class="form-control" name="github" type="text" value="{{ $user->profile->github }}" id="github">
                            </div>
                            <span class="help-block">{{ $errors->first('github', ':message') }}</span>
                        </div>
                    </div>
                    <!-- /.github -->

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group {{ $errors->has('bio') ? 'has-error' : '' }}">
                        <label for="bio" class="control-label">
                            {{ __('user/profile.bio') }}
                        </label>

                        <div class="controls">
                            <textarea class="form-control" name="bio" cols="50" rows="10" id="bio">{{ $user->profile->bio }}</textarea>
                            <span class="help-block">{{ $errors->first('question', ':message') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        {{ __('button.save') }} <i class="fa fa-floppy-o"></i>
                    </button>
                </div>
            </div>

            </form>

        </div>
        <!-- /.box-body -->
    </div>
@endsection

@push('styles')
    <!-- Date Picker -->
    <link rel="stylesheet"
          href="{{ asset('vendor/AdminLTE/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <!-- File Input -->
    <link rel="stylesheet" href="{{ asset('vendor/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
@endpush

{{-- Scripts --}}
@push('scripts')
    <!-- Date Picker -->
    <script type="text/javascript"
            src="{{ asset('vendor/AdminLTE/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- File Input -->
    <script type="text/javascript"
            src="{{ asset('vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>

    <script>
        $('.date-picker').datepicker({
            format: 'yyyy-mm-dd',
            endDate: '0d',
            autoclose: true
        });
    </script>
@endpush


