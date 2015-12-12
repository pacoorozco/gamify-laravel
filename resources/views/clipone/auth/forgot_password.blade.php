@extends('layouts.login')

{{-- Web site Title --}}
@section('title')
{{{ trans('user/user.forgot_password') }}} ::
@stop

{{-- Content --}}
@section('content')

<!-- start: FORGOT BOX -->
<div class="box-forgot">
    <h3>{{ trans('user/user.forgot_password_title') }}</h3>
    <p>
        {{ trans('user/user.forgot_password_instructions') }}
    </p>
    {{ Form::open(array('url' => array('user/forgot_password'), 'class' => 'form-forgot')) }}
    <!-- Notifications -->
    @include('notifications')
    <!-- ./ notifications -->
    <fieldset>
        <div class="form-group">
            <span class="input-icon">
                {{ Form::text('email', null, array(
                            'class' => 'form-control',
                            'placeholder' => trans('confide::confide.e_mail')
                            )) }}
                <i class="fa fa-envelope"></i> </span>
        </div>
        <div class="form-actions">
            <a href="{{ URL::to('user/login') }}" class="btn btn-light-grey go-back">
                {{ trans('button.back') }}
            </a>
            <button type="submit" class="btn btn-bricky pull-right">
                {{ trans('button.submit') }}
            </button>
        </div>
    </fieldset>
    {{ Form::close() }}
</div>
<!-- end: FORGOT BOX -->
@stop
