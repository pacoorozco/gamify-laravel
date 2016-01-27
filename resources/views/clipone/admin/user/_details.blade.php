
<div class="row">
    <div class="col-xs-12">

        <dl class="dl-horizontal">

        <!-- username -->
        <dt>{{ trans('admin/user/model.username') }}</dt>
        <dd>{{ $user->username }}</dd>
        <!-- ./ username -->

        <!-- fullname -->
        <dt>{{ trans('admin/user/model.name') }}</dt>
        <dd>{{ $user->name }}</dd>
        <!-- ./ fullname -->

        <!-- email -->
        <dt>{{ trans('admin/user/model.email') }}</dt>
        <dd>{{ $user->email }}</dd>
        <!-- ./ email -->

        <!-- roles -->
        <dt>{{ trans('admin/user/model.role') }}</dt>
        <dd>{{ $user->role }}</dd>
        <!-- ./ roles -->

        </dl>
        
    </div>
</div>

<div class="row">
    <div class="col-xs-12">

        <div class="form-group">
            <div class="controls">
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{ trans('general.back') }}</a>
                @if ($action == 'show')
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">{!! trans('button.edit') !!}</a>
                @else
                {!! Form::button(trans('button.delete'), array('type' => 'submit', 'class' => 'btn btn-danger')) !!}
                @endif
            </div>
        </div>

    </div>
</div>
