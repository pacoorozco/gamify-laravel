<div class="row">
    <div class="col-xs-6">

        <!-- name -->
        <div class="form-group">
            {!! Form::label('name', trans('admin/level/model.name'), array('class' => 'control-label')) !!}
            <div class="controls">
                {{ $level->name }}
            </div>
        </div>
        <!-- ./ name -->

        <!-- amount_needed -->
        <div class="form-group">
            {!! Form::label('amount_needed', trans('admin/level/model.amount_needed'), array('class' => 'control-label')) !!}
            <div class="controls">
                {{ $level->amount_needed }}
            </div>
        </div>
        <!-- ./ amount_needed -->

        <!-- Activation Status -->
        <div class="form-group">
            {!! Form::label('active', trans('admin/level/model.active'), array('class' => 'control-label')) !!}
            <div class="controls">
                {{ ($level->active ? trans('general.yes') : trans('general.no')) }}
            </div>
        </div>
        <!-- ./ activation status -->

    </div>
    <div class="col-xs-6">

        <!-- image -->
        <div class="form-group">
            {!! Form::label('image', trans('admin/level/model.image'), array('class' => 'control-label')) !!}
            <div class="controls">
                @if (isset($level))
                    <img src="{{ $level->image->url('big') }}" class="img-thumbnail" alt="Big size"/>
                    <img src="{{ $level->image->url('medium') }}" class="img-thumbnail" alt="Medium size"/>
                    <img src="{{ $level->image->url('small') }}" class="img-thumbnail" alt="Small size"/>
                @endif
            </div>
        </div>
        <!-- ./ image -->
    </div>
</div>
<div class="row">
    <div class="col-xs-12">


        <div class="form-group">
            <div class="controls">
                <a href="{{ route('admin.levels.index') }}" class="btn btn-primary"><i
                            class="fa fa-arrow-left"></i> {{ trans('general.back') }}</a>
                @if ($action == 'show')
                    <a href="{{ URL::route('admin.levels.edit', $level->id) }}" class="btn btn-primary"><i
                                class="fa fa-pencil"></i> {{ trans('general.edit') }}</a>
                @else
                    {!! Form::button('<i class="fa fa-trash-o"></i>' . trans('general.delete'), array('type' => 'submit', 'class' => 'btn btn-danger')) !!}
                @endif
            </div>
        </div>
    </div>
</div>