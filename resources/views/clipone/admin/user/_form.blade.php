{{-- Create / Edit User Form --}}

@if (isset($user))
{!! Form::model($user, array(
            'route' => array('admin.users.update', $user->id),
            'method' => 'put'
            )) !!}
@else
{!! Form::open(array(
            'route' => array('admin.users.store'),
            'method' => 'post'
            )) !!}
@endif

<div class="row">
    <div class="col-xs-6">

        <!-- username -->
        <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
            {!! Form::label('username', trans('admin/user/model.username'), array('class' => 'control-label')) !!}
            <div class="controls">
                {{-- TODO: If $user->username == 'admin' this input text must be disabled --}}
                @if ($action == 'create')
                {!! Form::text('username', null, array('class' => 'form-control')) !!}
                @else
                {!! Form::text('username', null, array('disabled' => 'disabled', 'class' => 'form-control')) !!}
                @endif
                <span class="help-block">{{ $errors->first('username', ':message') }}</span>
            </div>
        </div>
        <!-- ./ username -->

        <!-- name -->
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            {!! Form::label('name', trans('admin/user/model.name'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('name', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('name', ':message') }}</span>
            </div>
        </div>
        <!-- ./ name -->

        <!-- Email -->
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            {!! Form::label('email', trans('admin/user/model.email'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::email('email', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('email', ':message') }}</span>
            </div>
        </div>
        <!-- ./ email -->

        <!-- Password -->
        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            {!! Form::label('password', trans('admin/user/model.password'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::password('password', array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('password', ':message') }}</span>
            </div>
        </div>
        <!-- ./ password -->

        <!-- Password Confirm -->
        <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
            {!! Form::label('password_confirmation', trans('admin/user/model.password_confirmation'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('password_confirmation', ':message') }}</span>
            </div>
        </div>
        <!-- ./ password confirm -->

    </div>
    <div class="col-xs-6">

        <!-- role -->
        <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">
            {!! Form::label('role', trans('admin/user/model.role'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('role', array('default' => 'Default', 'administrator' => 'Administrator'), null, ['class' => 'form-control']) !!}
                <span class="help-block">
                    {{ trans('admin/user/messages.roles_help') }}
                </span>
            </div>
        </div>
        <!-- ./ role -->

    </div>
</div>

<div class="row">
    <div class="col-xs-12">

        <!-- Form Actions -->
        <div class="form-group">
            <div class="controls">
                {!! Form::button(trans('button.save'), array('type' => 'submit', 'class' => 'btn btn-success')) !!}
            </div>
        </div>
        <!-- ./ form actions -->

    </div>
</div>

{!! Form::close() !!}
