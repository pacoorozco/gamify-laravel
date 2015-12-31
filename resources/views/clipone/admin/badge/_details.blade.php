
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

        <!-- amount_needed -->
        <div class="form-group">
            {!! Form::label('amount_needed', trans('admin/badge/model.amount_needed'), array('class' => 'control-label')) !!}
            <div class="controls">
                {{ $badge->amount_needed }}
            </div>
        </div>
        <!-- ./ amount_needed -->

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
                <img src="{{ $badge->image->url('big') }}" class="img-thumbnail" alt="Big size" />
                <img src="{{ $badge->image->url('medium') }}" class="img-thumbnail" alt="Medium size" />
                <img src="{{ $badge->image->url('small') }}" class="img-thumbnail" alt="Small size" />
            </div>
        </div>
        <!-- ./ image -->

    </div>
</div>

<div class="row">
    <div class="col-xs-12">

        <div class="form-group">
            <div class="controls">
                <a href="{{ route('admin.badges.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> {{ trans('general.back') }}</a>
                @if ($action == 'show')
                <a href="{{ route('admin.badges.edit', $badge) }}" class="btn btn-primary"><i class="fa fa-pencil"></i> {{ trans('general.edit') }}</a>
                @else
                {!! Form::button('<i class="fa fa-trash-o"></i>' . trans('general.delete'), array('type' => 'submit', 'class' => 'btn btn-danger')) !!}
                @endif
            </div>
        </div>
    </div>
</div>

