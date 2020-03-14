<div class="box">
    <div class="box-body">

        <!-- username -->
        <div class="form-group">
            {!! Form::label('username', __('admin/user/model.username'), array('class' => 'control-label')) !!}
            <div class="controls">
                {{ $user->username }}
            </div>
        </div>
        <!-- ./ username -->

        <!-- fullname -->
        <div class="form-group">
            {!! Form::label('fullname', __('admin/user/model.name'), array('class' => 'control-label')) !!}
            <div class="controls">
                {{ $user->name }}
            </div>
        </div>
        <!-- ./ fullname -->

        <!-- email -->
        <div class="form-group">
            {!! Form::label('email', __('admin/user/model.email'), array('class' => 'control-label')) !!}
            <div class="controls">
                {{ $user->email }}
            </div>
        </div>
        <!-- ./ email -->

        <!-- roles -->
        <div class="form-group">
            {!! Form::label('roles', __('admin/user/model.role'), array('class' => 'control-label')) !!}
            <div class="controls">
                {{ __('admin/user/model.roles_list.' . $user->role) }}
            </div>
        </div>
        <!-- ./ roles -->
    </div>
    <div class="box-footer">
        <a href="{{ route('admin.users.index') }}">
            <button type="button" class="btn btn-primary">
                <i class="fa fa-arrow-left"></i> @lang('general.back')
            </button>
        </a>
        @if ($action == 'show')
            <a href="{{ route('admin.users.edit', $user) }}">
                <button type="button" class="btn btn-primary">
                    <i class="fa fa-pencil"></i> @lang('general.edit')
                </button>
            </a>
        @else
            {!! Form::button(__('button.delete'), array('type' => 'submit', 'class' => 'btn btn-danger')) !!}
        @endif
    </div>
</div>
