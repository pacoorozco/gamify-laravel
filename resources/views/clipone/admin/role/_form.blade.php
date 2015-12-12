{{-- Create Role Form --}}

@if (isset($role))
{{ Form::model($role, array(
            'route' => array('admin.roles.update', $role->id),
            'method' => 'put',
            )) }}
@else
{{ Form::open(array(
            'route' => array('admin.roles.store'),
            'method' => 'post',
            )) }}
@endif
<!-- {{ var_dump($permissions) }} -->
<div class="row">
    <div class="col-xs-6">

        <!-- role name -->
        <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
            {{ Form::label('name', trans('admin/role/model.name'), array('class' => 'control-label')) }}
            <div class="controls">
                @if (isset($role) && $role->name === 'admin')
                {{ Form::text('name', null, array('disabled', 'class' => 'form-control')) }}
                @else
                {{ Form::text('name', null, array('class' => 'form-control')) }}
                @endif
                <span class="help-block">{{{ $errors->first('name', ':message') }}}</span>
            </div>
        </div>
        <!-- ./ role name -->

        <!-- role description -->
        <div class="form-group {{{ $errors->has('description') ? 'has-error' : '' }}}">
            {{ Form::label('description', trans('admin/role/model.description'), array('class' => 'control-label')) }}
            <div class="controls">
                {{ Form::text('description', null, array('class' => 'form-control')) }}
                <span class="help-block">{{{ $errors->first('description', ':message') }}}</span>
            </div>
        </div>
        <!-- ./ role name -->
    </div>
    <div class="col-xs-6">
            <div class="panel panel-default">
        	<div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
                    Permissions
                    <div class="panel-tools">
                    </div>
                </div>
                <div class="panel-body">
        <fieldset>
            <div class="form-group">
                @foreach ($permissions as $permission)
                <div class="checkbox">
                    <label class="checkbox-inline">
                        {{ Form::checkbox('permissions[' . $permission['id'] . ']', 1, (isset($permission['checked']) ? true : false), array('class' => 'square-green')) }}
                        {{{ $permission['display_name'] }}}
                    </label>
                </div>
                @endforeach
            </div>
        </fieldset>
                </div>
            </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
    <!-- Form Actions -->
    <div class="form-group">
        <div class="controls">
            {{ Form::button(trans('button.save'), array('type' => 'submit', 'class' => 'btn btn-success')) }}
        </div>
    </div>
    <!-- ./ form actions -->
    </div>
</div>

{{ Form::close() }}