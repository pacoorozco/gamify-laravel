<div class="box">
    <div class="box-body">

        <div class="row">
            <div class="col-xs-6">

                <!-- name -->
                <div class="form-group">
                    {!! Form::label('name', trans('admin/badge/model.name'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {{ $badge->name }}
                    </div>
                </div>
                <!-- ./ name -->

                <!-- description -->
                <div class="form-group">
                    {!! Form::label('description', trans('admin/badge/model.description'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {{ $badge->description }}
                    </div>
                </div>
                <!-- ./ description -->

                <!-- required_repetitions -->
                <div class="form-group">
                    {!! Form::label('required_repetitions', trans('admin/badge/model.required_repetitions'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {{ $badge->required_repetitions }}
                    </div>
                </div>
                <!-- ./ required_repetitions -->

                <!-- Activation Status -->
                <div class="form-group">
                    {!! Form::label('active', trans('admin/badge/model.active'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {{ ($badge->active ? trans('general.yes') : trans('general.no')) }}
                    </div>
                </div>
                <!-- ./ activation status -->

            </div>
            <div class="col-xs-6">

                <!-- image -->
                <div class="form-group">
                    {!! Form::label('image', trans('admin/badge/model.image'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        <img src="{{ $badge->getImageURL() }}" class="img-thumbnail" alt="Big size">
                    </div>
                </div>
                <!-- ./ image -->

            </div>
        </div>

    </div>
    <div class="box-footer">
        <a href="{{ route('admin.badges.index') }}">
            <button type="button" class="btn btn-primary">
                <i class="fa fa-arrow-left"></i> {{ trans('general.back') }}
            </button>
        </a>
        @if ($action == 'show')
            <a href="{{ route('admin.badges.edit', $badge) }}">
                <button type="button" class="btn btn-primary">
                    <i class="fa fa-pencil"></i> {{ trans('general.edit') }}
                </button>
            </a>
        @else
            {!! Form::button('<i class="fa fa-trash-o"></i>' . trans('general.delete'), array('type' => 'submit', 'class' => 'btn btn-danger')) !!}
        @endif
    </div>
</div>

