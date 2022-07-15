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
                            {!! Form::text('username', $user->username, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
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

            </div>
            <div class="col-xs-6">

                <!-- role -->
                <div class="form-group {{ $errors->has('role') ? 'has-error' : '' }}">
                    {!! Form::label('role', __('admin/user/model.role'), array('class' => 'control-label required')) !!}
                    <div class="controls">
                        @if(isset($user) && Gate::denies('update-role', $user))
                            {!! Form::select('role', \Gamify\Enums\Roles::asSelectArray(), $user->role, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                            {!! Form::hidden('role', $user->role) !!}
                        @else
                            {!! Form::select('role', \Gamify\Enums\Roles::asSelectArray(), \Gamify\Enums\Roles::Player, ['class' => 'form-control', 'required' => 'required']) !!}
                            <p class="text-muted">{{ __('admin/user/messages.roles_help') }}</p>
                        @endif
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
                <i class="fa fa-arrow-left"></i> {{ __('general.back') }}
            </button>
        </a>
    {!! Form::button(__('button.save') . ' <i class="fa fa-floppy-o"></i>', array('type' => 'submit', 'class' => 'btn btn-success')) !!}
    <!-- ./ form actions -->
    </div>
</div>

{!! Form::close() !!}
