<div class="box">
    <div class="box-body">

        <div class="row">
            <div class="col-xs-6">

                <!-- name -->
                <div class="form-group">
                    {!! Form::label('name', __('admin/badge/model.name'), ['class' => 'control-label']) !!}
                    <div class="controls">
                        {{ $badge->present()->name }}
                    </div>
                </div>
                <!-- ./ name -->

                <!-- description -->
                <div class="form-group">
                    {!! Form::label('description', __('admin/badge/model.description'), ['class' => 'control-label']) !!}
                    <div class="controls">
                        {{ $badge->present()->description }}
                    </div>
                </div>
                <!-- ./ description -->

                <!-- required_repetitions -->
                <div class="form-group">
                    {!! Form::label('required_repetitions', __('admin/badge/model.required_repetitions'), ['class' => 'control-label']) !!}
                    <div class="controls">
                        {{ $badge->present()->required_repetitions }}
                    </div>
                </div>
                <!-- ./ required_repetitions -->

                <!-- Activation Status -->
                <div class="form-group">
                    {!! Form::label('active', __('admin/badge/model.active'), ['class' => 'control-label']) !!}
                    <div class="controls">
                        {{ $badge->present()->status }}
                    </div>
                </div>
                <!-- ./ activation status -->

            </div>
            <div class="col-xs-6">

                <!-- image -->
                <div class="form-group">
                    {!! Form::label('image', __('admin/badge/model.image'), ['class' => 'control-label']) !!}
                    <div class="controls">
                       {{ $badge->present()->imageThumbnail }}
                    </div>
                </div>
                <!-- ./ image -->

            </div>
        </div>

    </div>
    <div class="box-footer">
        <a href="{{ route('admin.badges.index') }}">
            <button type="button" class="btn btn-primary">
                <i class="fa fa-arrow-left"></i> @lang('general.back')
            </button>
        </a>
        @if ($action == 'show')
            <a href="{{ route('admin.badges.edit', $badge) }}">
                <button type="button" class="btn btn-primary">
                    <i class="fa fa-pencil"></i> @lang('general.edit')
                </button>
            </a>
        @else
            {!! Form::button('<i class="fa fa-trash-o"></i> ' . __('general.delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
        @endif
    </div>
</div>

