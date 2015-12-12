{{-- Role Details --}}

<div class="row">
    <div class="col-xs-6">

        <!-- name -->
<div class="form-group">
	<label class="control-label" for="name">Name</label>
	<div class="controls">
		@if (isset($role)) {{{ $role->name }}} @endif
	</div>
</div>
<!-- ./ name -->

<!-- description -->
<div class="form-group">
	<label class="control-label" for="name">Description</label>
	<div class="controls">
		@if (isset($role)) {{{ $role->description }}} @endif
	</div>
</div>
<!-- ./ description -->

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
                        {{ Form::checkbox('permissions[' . $permission['id'] . ']', 1, (isset($permission['checked']) ? true : false), array('disabled', 'class' => 'square-green')) }}
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
<div class="form-group">
    <div class="controls">
        <a href="{{ route('admin.roles.index') }}" class="btn btn-primary">{{ trans('button.back') }}</a>
        @if ($action == 'show')
        <a href="{{ URL::route('admin.roles.edit', $role->id) }}" class="btn btn-primary">{{ trans('button.edit') }}</a>
        @else
        {{ Form::button(trans('button.delete'), array('type' => 'submit', 'class' => 'btn btn-danger')) }}
        @endif
    </div>
</div>
    </div>
</div>

