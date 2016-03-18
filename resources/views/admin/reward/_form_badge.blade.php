{!! Form::open(array('route' => array('admin.rewards.badge'), 'method' => 'post')) !!}

<div class="box box-solid">
    <div class="box-header">
        <i class="fa fa-gift"></i>
        <h3 class="box-title">{{ trans('admin/reward/messages.give_badge') }}</h3>
    </div>
    <div class="box-body">
        <!-- username -->
        <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
            {!! Form::label('username', trans('admin/reward/messages.username'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('username', $users, null,
                array('class' => 'form-control username-input', 'placeholder' => '')) !!}
                <span class="help-block">{{ $errors->first('username', ':message') }}</span>
            </div>
        </div>
        <!-- ./ username -->

        <!-- badges -->
        <div class="form-group {{ $errors->has('badge') ? 'has-error' : '' }}">
            {!! Form::label('badge', trans('admin/reward/messages.badge'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::select('badge', $badges,
                null, array('class' => 'form-control badge-input', 'placeholder' => '')) !!}
                <span class="help-block">{{ $errors->first('badge', ':message') }}</span>
            </div>
        </div>
        <!-- ./ badges -->
    </div>
    <div class="box-footer">
        {!! Form::button(trans('button.save'), array('type' => 'submit', 'class' => 'btn btn-success')) !!}
    </div>
</div>

{!! Form::close() !!}