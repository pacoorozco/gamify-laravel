@extends('layouts.master')

{{-- Web site Title --}}
@section('title', __('passwords.confirm_password'))

{{-- Content Header --}}
@section('header', __('passwords.confirm_password'))

@section('content')

    <!-- panel -->
    <div class="panel panel-default">
        <div class="panel-body">

            <p class="text-center">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>

            <form class="form-horizontal" method="post" action="{{ route('password.confirm') }}">
                @csrf

                <!-- password -->
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">
                        {{ __('passwords.password') }}
                    </label>

                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                </div>
                <!-- /. password -->

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('passwords.confirm_password_action') }}
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
