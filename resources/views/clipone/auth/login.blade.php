@extends('layouts.login')

{{-- Web site Title --}}
@section('title')
    {{ trans('auth.login') }} ::
    @stop

    {{-- Content --}}
    @section('content')
            <!-- start: LOGIN BOX -->
    <div class="box-login">
        <h3>{{ trans('auth.sign_title') }}</h3>
        <p>
            {{ trans('auth.sign_instructions') }}
        </p>
        {!! Form::open(array('url' => 'auth/login', 'class' => 'form-login')) !!}

                <!-- Notifications -->
        @include('partials.notifications')
                <!-- ./ notifications -->

        <fieldset>
            <div class="form-group">
            <span class="input-icon">
                {!! Form::text('username', null, array(
                            'class' => 'form-control',
                            'placeholder' => trans('auth.username')
                            )) !!}
                <i class="fa fa-user"></i> </span>
            </div>
            <div class="form-group form-actions">
            <span class="input-icon">
                {!! Form::password('password', array(
                            'class' => 'form-control password',
                            'placeholder' => trans('auth.password')
                            )) !!}
                <i class="fa fa-lock"></i>
                <a class="forgot" href="{{ URL::to('auth/forgot_password') }}">
                    {{ trans('auth.forgot_password') }}
                </a> </span>
            </div>
            <div class="form-actions">
                <label for="remember" class="checkbox-inline">
                    {!! Form::checkbox('remember', '1', false, array('class' => 'grey remember')) !!}
                    {{ trans('auth.remember_me') }}
                </label>
                <button type="submit" class="btn btn-bricky pull-right">
                    {{ trans('auth.login') }} <i class="fa fa-arrow-circle-right"></i>
                </button>
            </div>
            <div class="new-account">
                {{ trans('auth.dont_have_account') }}
                <a href="{{ URL::to('auth/register') }}" class="register">
                    {{ trans('auth.create_account') }}
                </a>
            </div>
        </fieldset>
        {!! Form::close() !!}
    </div>
    <!-- end: LOGIN BOX -->
@stop
