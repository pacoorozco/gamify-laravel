<div class="box">
    <div class="box-body">

        <div class="row">
            <div class="col-xs-6">

                <!-- name -->
                <div class="form-group">
                    {!! Form::label('name', __('admin/level/model.name'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {{ $level->name }}
                    </div>
                </div>
                <!-- ./ name -->

                <!-- required_points -->
                <div class="form-group">
                    {!! Form::label('required_points', __('admin/level/model.required_points'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {{ $level->required_points }}
                    </div>
                </div>
                <!-- ./ required_points -->

                <!-- Activation Status -->
                <div class="form-group">
                    {!! Form::label('active', __('admin/level/model.active'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {{ ($level->active ? __('general.yes') : trans('general.no')) }}
                    </div>
                </div>
                <!-- ./ activation status -->

            </div>
            <div class="col-xs-6">

                <!-- image -->
                <div class="form-group">
                    {!! Form::label('image', __('admin/level/model.image'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        @if (isset($level))
                            <img src="{{ $level->getImageURL() }}" class="img-thumbnail" alt="Big size">
                        @endif
                    </div>
                </div>
                <!-- ./ image -->
            </div>
        </div>
    </div>
    <div class="box-footer">
        <a href="{{ route('admin.levels.index') }}">
            <button type="button" class="btn btn-primary">
                <i class="fa fa-arrow-left"></i> @lang('general.back')
            </button>
        </a>
        @if ($action == 'show')
            <a href="{{ route('admin.levels.edit', $level) }}">
                <button type="button" class="btn btn-primary">
                    <i class="fa fa-pencil"></i> @lang('general.edit')
                </button>
            </a>
        @else
            {!! Form::button('<i class="fa fa-trash-o"></i>' . __('general.delete'), array('type' => 'submit', 'class' => 'btn btn-danger')) !!}
        @endif
    </div>
</div>
