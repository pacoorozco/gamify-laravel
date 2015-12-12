{{-- Create / Edit Badge Form --}}

<div class="box box-primary">

    @if (isset($badge))
    {{ Form::model($badge, array(
            'route' => array('admin.badges.update', $badge->id),
            'method' => 'put',
            'files' => true,
            
            )) }}
    @else
    {{ Form::open(array(
            'route' => array('admin.badges.store'),
            'method' => 'post',
            'files' => true,
            
            )) }}
    @endif

    <div class="row">
        <div class="col-xs-6">

            <!-- name -->
            <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
                {{ Form::label('name', trans('admin/badge/model.name'), array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::text('name', null, array('class' => 'form-control')) }}
                    <span class="help-block">{{{ $errors->first('name', ':message') }}}</span>
                </div>
            </div>
            <!-- ./ name -->

            <!-- description -->
            <div class="form-group {{{ $errors->has('description') ? 'has-error' : '' }}}">
                {{ Form::label('description', trans('admin/badge/model.description'), array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::textarea('description', null, array('class' => 'form-control')) }}
                    <span class="help-block">{{{ $errors->first('description', ':message') }}}</span>
                </div>
            </div>
            <!-- ./ description -->

            <!-- amount_needed -->
            <div class="form-group {{{ $errors->has('amount_needed') ? 'has-error' : '' }}}">
                {{ Form::label('amount_needed', trans('admin/badge/model.amount_needed'), array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::number('amount_needed', null, array('class' => 'form-control')) }}
                    <p class='help-block'>{{{ trans('admin/badge/model.amount_needed_help') }}}</p>
                    <span class="help-block">{{{ $errors->first('amount_needed', ':message') }}}</span>

                </div>
            </div>
            <!-- ./ amount_needed -->

        </div>
        <div class="col-xs-6">

            <!-- image -->
            <div class="form-group {{{ $errors->has('image') ? 'has-error' : '' }}}">
                {{ Form::label('image', trans('admin/badge/model.image'), array('class' => 'control-label')) }}
                <div class="controls">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style="width: 150px; height: 150px;">
                            @if (isset($badge))
                            <img src='{{ $badge->image->url() }}' class='file-preview-image' />
                            @endif
                        </div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                            <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture-o"></i> {{ trans('button.pick_image') }}</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> {{ trans('button.upload_image') }}</span>
                                {{ Form::file('image') }}
                            </span>
                            <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                <i class="fa fa-times"></i> {{ trans('button.delete_image') }}
                            </a>
                        </div>
                    </div>
                    <p class='help-block'>{{{ trans('admin/badge/model.image_help') }}}</p>
                    <span class="help-block">{{{ $errors->first('image', ':message') }}}</span>
                </div>
            </div>
            <!-- ./ image -->

            <!-- activation status -->
            <div class="form-group {{{ $errors->has('active') ? 'has-error' : '' }}}">
                {{ Form::label('active', trans('admin/badge/model.active'), array('class' => 'control-label')) }}
                <div class="controls">
                    {{ Form::select('active', array('1' => trans('general.yes'), '0' => trans('general.no')), null, array('class' => 'form-control')) }}
                    {{ $errors->first('active', '<span class="help-inline">:message</span>') }}
                </div>
            </div>
            <!-- ./ activation status -->
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">

            <!-- Form Actions -->
            <div class="form-group">
                <div class="controls">
                    {{ Form::button(trans('button.save'), array('type' => 'submit', 'class' => 'btn btn-success')) }}
                </div>
            </div>
            <!-- ./ form actions -->
        </div>
    </div>
    {{ Form::close() }}

    {{-- Styles --}}
    @section('styles')
    <!-- File Input -->
    {{ HTML::style(Theme::asset('plugins/bootstrap-fileupload/bootstrap-fileupload.min.css')) }}
    @stop

    {{-- Scripts --}}
    @section('scripts')
    <!-- File Input -->
    {{ HTML::script(Theme::asset('plugins/bootstrap-fileupload/bootstrap-fileupload.min.js')) }}
    @stop