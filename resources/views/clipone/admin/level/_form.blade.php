{{-- Create / Edit Level Form --}}

<div class="box box-primary">

    @if (isset($level))
        {!! Form::model($level, array(
                'route' => array('admin.levels.update', $level),
                'method' => 'put',
                'files' => true,

                )) !!}
    @else
        {!! Form::open(array(
                'route' => array('admin.levels.store'),
                'method' => 'post',
                'files' => true,

                )) !!}
    @endif

    <div class="box-body">

        <div class="row">
            <div class="col-xs-6">

                <!-- name -->
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    {!! Form::label('name', trans('admin/level/model.name'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::text('name', null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
                <!-- ./ name -->

                <!-- amount_needed -->
                <div class="form-group {{ $errors->has('amount_needed') ? 'has-error' : '' }}">
                    {!! Form::label('amount_needed', trans('admin/level/model.amount_needed'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::number('amount_needed', null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('amount_needed', ':message') }}</span>
                    </div>
                </div>
                <!-- ./ amount_needed -->

                <!-- activation status -->
                <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">
                    {!! Form::label('active', trans('admin/level/model.active'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::select('active', array('1' => trans('general.yes'), '0' => trans('general.no')), null, array('class' => 'form-control')) !!}
                        {{ $errors->first('active', '<span class="help-inline">:message</span>') }}
                    </div>
                </div>
                <!-- ./ activation status -->

            </div>
            <div class="col-xs-6">

                <!-- image -->
                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                    {!! Form::label('image', trans('admin/level/model.image'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 150px; height: 150px;">
                                @if (isset($level))
                                    <img src='{{ $level->image->url() }}' class='file-preview-image'/>
                                @endif
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail"
                                 style="max-width: 150px; max-height: 150px; line-height: 20px;"></div>
                            <div>
                                <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i
                                                class="fa fa-picture-o"></i> {{ trans('button.pick_image') }}</span><span
                                            class="fileupload-exists"><i
                                                class="fa fa-picture-o"></i> {{ trans('button.upload_image') }}</span>
                                    {!! Form::file('image') !!}
                                </span>
                                <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                    <i class="fa fa-times"></i> {{ trans('button.delete_image') }}
                                </a>
                            </div>
                        </div>
                        <p class='help-block'>{{ trans('admin/level/model.image_help') }}</p>
                        <span class="help-block">{{ $errors->first('image', ':message') }}</span>
                    </div>
                </div>
                <!-- ./ image -->

            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">

                <!-- Form Actions -->
                <div class="form-group">
                    <div class="controls">
                        {!! Form::button(trans('button.save'), array('type' => 'submit', 'class' => 'btn btn-success')) !!}
                    </div>
                </div>
                <!-- ./ form actions -->

            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

{{-- Styles --}}
@section('styles')
        <!-- File Input -->
{!! HTML::style(Theme::url('plugins/bootstrap-fileupload/bootstrap-fileupload.min.css')) !!}
@endsection

{{-- Scripts --}}
@section('scripts')
        <!-- File Input -->
{!! HTML::script(Theme::url('plugins/bootstrap-fileupload/bootstrap-fileupload.min.js')) !!}
@endsection