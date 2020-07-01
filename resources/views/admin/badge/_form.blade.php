{{-- Create / Edit Badge Form --}}
@if (isset($badge))
    {!! Form::model($badge, ['route' => ['admin.badges.update', $badge], 'method' => 'put', 'files' => true]) !!}
@else
    {!! Form::open(['route' => 'admin.badges.store', 'method' => 'post', 'files' => true]) !!}
@endif

<div class="box box-solid">
    <div class="box-body">

        <div class="row">
            <div class="col-xs-6">
                <!-- name -->
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    {!! Form::label('name', __('admin/badge/model.name'), ['class' => 'control-label required']) !!}
                    <div class="controls">
                        {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
                <!-- ./ name -->

                <!-- description -->
                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                    {!! Form::label('description', __('admin/badge/model.description'), ['class' => 'control-label required']) !!}
                    <div class="controls">
                        {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        <span class="help-block">{{ $errors->first('description', ':message') }}</span>
                    </div>
                </div>
                <!-- ./ description -->

                <!-- required_repetitions -->
                <div class="form-group {{ $errors->has('required_repetitions') ? 'has-error' : '' }}">
                    {!! Form::label('required_repetitions', __('admin/badge/model.required_repetitions'), ['class' => 'control-label required']) !!}
                    <div class="controls">
                        {!! Form::number('required_repetitions', null, ['class' => 'form-control', 'required' => 'required', 'min' => '1']) !!}
                        <p class="text-muted">@lang('admin/badge/model.required_repetitions_help')</p>
                        <span class="help-block">{{ $errors->first('required_repetitions', ':message') }}</span>

                    </div>
                </div>
                <!-- ./ required_repetitions -->

                <!-- actuators -->
                <div class="form-group {{ $errors->has('actuators') ? 'has-error' : '' }}">
                    {!! Form::label('actuators', __('admin/badge/model.actuators'), ['class' => 'control-label']) !!}
                    <div class="controls">
                        {!! Form::select('actuators', $actuators_list, $selected_actuators, ['class' => 'form-control actuators-select', 'required' => 'required']) !!}
                        <p class="text-muted">@lang('admin/badge/model.actuators_help')</p>
                        <span class="help-block">{{ $errors->first('actuators', ':message') }}</span>
                    </div>
                </div>
                <!-- ./ actuators -->

            </div>
            <div class="col-xs-6">

                <!-- image -->
                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                    {!! Form::label('image', __('admin/badge/model.image'), ['class' => 'control-label required']) !!}
                    <p class="text-muted">@lang('admin/badge/model.image_help')</p>
                    <div class="controls">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                 style="width: 150px; height: 150px;">
                                @isset($badge)
                                    {{ $badge->present()->imageTag }}
                                @endisset
                            </div>
                            <p>
                            <span class="btn btn-default btn-file">
                                <span class="fileinput-new"><i
                                        class="fa fa-picture-o"></i> @lang('button.pick_image')</span>
                                <span class="fileinput-exists"><i
                                        class="fa fa-picture-o"></i> @lang('button.upload_image')</span>
                                {!! Form::file('image') !!}
                            </span>
                                <a href="#" class="btn fileinput-exists btn-default" data-dismiss="fileinput">
                                    <i class="fa fa-times"></i> @lang('button.delete_image')
                                </a>
                            </p>
                        </div>
                    </div>
                    <span class="help-block">{{ $errors->first('image', ':message') }}</span>
                </div>
                <!-- ./ image -->

                <!-- activation status -->
                <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">
                    {!! Form::label('active', __('admin/badge/model.active'), ['class' => 'control-label required']) !!}
                    <div class="controls">
                        {!! Form::select('active', ['1' => __('general.yes'), '0' => __('general.no')], null, ['class' => 'form-control', 'required' => 'required']) !!}
                        <span class="help-block">{{ $errors->first('active', ':message') }}</span>
                    </div>
                </div>
                <!-- ./ activation status -->

            </div>
        </div>
    </div>
    <div class="box-footer">
        <!-- form actions -->
        <a href="{{ route('admin.badges.index') }}">
            <button type="button" class="btn btn-primary">
                <i class="fa fa-arrow-left"></i> @lang('general.back')
            </button>
        </a>
    {!! Form::button(__('button.save'), ['type' => 'submit', 'class' => 'btn btn-success']) !!}
    <!-- ./ form actions -->
    </div>
</div>
{!! Form::close() !!}

{{-- Styles --}}
@push('styles')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/AdminLTE/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('vendor/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
@endpush

{{-- Scripts --}}
@push('scripts')
    <script
        src="{{ asset('vendor/AdminLTE/plugins/select2/js/select2.full.min.js') }}"></script>
    <script
        src="{{ asset('vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>

    <script>
        $(function () {
            $(".actuators-select").select2({
                width: '100%'
            });
        });
    </script>
@endpush
