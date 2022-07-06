@extends('layouts.master')

{{-- Web site Title --}}
@section('title', __('auth.change_password'))

{{-- Content Header --}}
@section('header', __('auth.change_password'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <!-- Notifications -->
                @include('partials.notifications')
                <!-- ./ notifications -->

                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="form-horizontal" method="post" action="{{ route('password.change') }}">
                            @csrf

                            {{-- current password --}}
                            <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                <label for="current-password"
                                       class="col-md-4 control-label">{{ __('auth.current_password') }}</label>

                                <div class="col-md-6">
                                    <input id="current-password" type="password" class="form-control"
                                           name="current-password" required>

                                    @if ($errors->has('current-password'))
                                        <span class="help-block">{{ $errors->first('current-password') }}</span>
                                    @endif
                                </div>
                            </div>
                            {{-- /.current password --}}

                            {{-- new password --}}
                            <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="col-md-4 control-label">{{ __('auth.new_password') }}</label>

                                <div class="col-md-6">
                                    <input id="new-password" type="password" class="form-control" name="new-password"
                                           required>

                                    @if ($errors->has('new-password'))
                                        <span class="help-block">{{ $errors->first('new-password') }}</span>
                                    @endif
                                </div>
                            </div>
                            {{-- /. new password --}}

                            {{-- new password confirmation --}}
                            <div class="form-group">
                                <label for="new-password-confirm"
                                       class="col-md-4 control-label">{{ __('auth.new_password_confirmation') }}</label>

                                <div class="col-md-6">
                                    <input id="new-password-confirm" type="password" class="form-control"
                                           name="new-password_confirmation" required>
                                </div>
                            </div>
                            {{-- new password confirmation --}}

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('button.update') }} <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
