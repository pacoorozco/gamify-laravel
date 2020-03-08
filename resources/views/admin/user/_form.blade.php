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

<div class="box box-solid">
    <div class="box-body">
        <div class="row">
            <div class="col-xs-6">

                <!-- username -->
                <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                    {!! Form::label('username', __('admin/user/model.username'), array('class' => 'control-label required')) !!}
                    <div class="controls">
                        @if ($action == 'create')
                            {!! Form::text('username', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        @else
                            {!! Form::text('username', null, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
                        @endif
                        <span class="help-block">{{ $errors->first('username', ':message') }}</span>
                    </div>
                </div>
                <!-- ./ username -->

                <!-- name -->
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    {!! Form::label('name', __('admin/user/model.name'), array('class' => 'control-label required')) !!}
                    <div class="controls">
                        {!! Form::text('name', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
                <!-- ./ name -->

                <!-- Email -->
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    {!! Form::label('email', __('admin/user/model.email'), array('class' => 'control-label required')) !!}
                    <div class="controls">
                        {!! Form::email('email', null, array('class' => 'form-control', 'required' => 'required')) !!}
                        <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                    </div>
                </div>
                <!-- ./ email -->

                <!-- Password -->
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    {!! Form::label('password', __('admin/user/model.password'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::password('password', array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                    </div>
                </div>
                <!-- ./ password -->

                <!-- Password Confirm -->
                <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                    {!! Form::label('password_confirmation', __('admin/user/model.password_confirmation'), array('class' => 'control-label')) !!}
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
                    {!! Form::label('role', __('admin/user/model.role'), array('class' => 'control-label required')) !!}
                    <div class="controls">
                        {!! Form::select('role', __('admin/user/model.roles_list'), null, ['class' => 'form-control', 'required' => 'required']) !!}
                        <p class="text-muted">@lang('admin/user/messages.roles_help')</p>
                    </div>
                </div>
                <!-- ./ role -->

            </div>
        </div>
    </div>
    <div class="box-footer">
        <!-- Form Actions -->
        <a href="{{ route('admin.users.index') }}">
            <button type="button" class="btn btn-primary">
                <i class="fa fa-arrow-left"></i> @lang('general.back')
            </button>
        </a>
        {!! Form::button(__('button.save'), array('type' => 'submit', 'class' => 'btn btn-success')) !!}
                <!-- ./ form actions -->
    </div>
</div>

{!! Form::close() !!}
