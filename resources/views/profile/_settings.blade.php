{!! Form::model($user->profile, array(
                                'route' => array('profiles.update', $user->username),
                                'method' => 'post',
                                'files' => true,
                                'role' => 'form',
                                                    )) !!}
<div class="row">
    <div class="col-md-6">

        <!-- name -->
        <div class="form-group">
            {!! Form::label('name', __('user/profile.name'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::text('name', $user->name, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
            </div>
        </div>
        <!-- /.name -->

        <!-- email -->
        <div class="form-group">
            {!! Form::label('email', __('user/profile.email'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::email('email', $user->email, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
            </div>
        </div>
        <!-- /.email -->

        <!-- date_of_birth -->
        <div class="form-group {{ $errors->has('date_of_birth') ? 'has-error' : '' }}">
            {!! Form::label('date_of_birth', __('user/profile.date_of_birth'), array('class' => 'control-label')) !!}
            <div class="controls">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    {!! Form::text('date_of_birth', $user->profile->date_of_birth, array('class' => 'form-control date-picker')) !!}
                </div>
                <span class="help-block">{{ $errors->first('date_of_birth', ':message') }}</span>
            </div>
        </div>
        <!-- /.date_of_birth -->

    </div>
    <div class="col-md-6">

        <!-- avatar -->
        <div class="form-group {{ $errors->has('avatar') ? 'has-error' : '' }}">
            {!! Form::label('avatar', __('user/profile.image'), array('class' => 'control-label')) !!}
            <div class="controls">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                         style="width: 150px; height: 150px;">
                        <img src="{{ $user->profile->avatarUrl }}" alt="Avatar">
                    </div>
                    <p>
                    <span class="btn btn-default btn-file">
                        <span class="fileinput-new">
                            <i class="fa fa-picture-o"></i> @lang('button.pick_image')
                        </span>
                        <span class="fileinput-exists">
                            <i class="fa fa-picture-o"></i> @lang('button.upload_image')
                        </span>
                        {!! Form::file('image') !!}
                    </span>
                        <a href="#" class="btn fileinput-exists btn-default" data-dismiss="fileinput">
                            <i class="fa fa-times"></i> @lang('button.delete_image')
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <!-- /.avatar -->

    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <h3>@lang('user/profile.additional_info')</h3>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-6">

        <!-- twitter -->
        <div class="form-group {{ $errors->has('twitter') ? 'has-error' : '' }}">
            {!! Form::label('twitter', __('user/profile.twitter'), array('class' => 'control-label')) !!}
            <div class="controls">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
                    {!! Form::text('twitter', null, array('class' => 'form-control')) !!}
                </div>
                <span class="help-block">{{ $errors->first('twitter', ':message') }}</span>
            </div>
        </div>
        <!-- /.twitter -->

        <!-- facebook -->
        <div class="form-group {{ $errors->has('facebook') ? 'has-error' : '' }}">
            {!! Form::label('facebook', __('user/profile.facebook'), array('class' => 'control-label')) !!}
            <div class="controls">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                    {!! Form::text('facebook', null, array('class' => 'form-control')) !!}
                </div>
                <span class="help-block">{{ $errors->first('facebook', ':message') }}</span>
            </div>
        </div>
        <!-- /.facebook -->

    </div>
    <div class="col-md-6">

        <!-- linkedin -->
        <div class="form-group {{ $errors->has('linkedin') ? 'has-error' : '' }}">
            {!! Form::label('linkedin', __('user/profile.linkedin'), array('class' => 'control-label')) !!}
            <div class="controls">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-linkedin"></i></span>
                    {!! Form::text('linkedin', null, array('class' => 'form-control')) !!}
                </div>
                <span class="help-block">{{ $errors->first('linkedin', ':message') }}</span>
            </div>
        </div>
        <!-- /.linkedin -->

        <!-- github -->
        <div class="form-group {{ $errors->has('github') ? 'has-error' : '' }}">
            {!! Form::label('github', __('user/profile.github'), array('class' => 'control-label')) !!}
            <div class="controls">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-github"></i></span>
                    {!! Form::text('github', null, array('class' => 'form-control')) !!}
                </div>
                <span class="help-block">{{ $errors->first('github', ':message') }}</span>
            </div>
        </div>
        <!-- /.github -->

    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group {{ $errors->has('bio') ? 'has-error' : '' }}">
            {!! Form::label('bio', __('user/profile.bio'), array('class' => 'control-label')) !!}
            <div class="controls">
                {!! Form::textarea('bio', null, array('class' => 'form-control')) !!}
                <span class="help-block">{{ $errors->first('question', ':message') }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        {!! Form::button(__('button.save'), array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
    </div>
</div>

{!! Form::close() !!}

@push('styles')
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('vendor/AdminLTE/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <!-- File Input -->
    <link rel="stylesheet" href="{{ asset('vendor/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
@endpush

{{-- Scripts --}}
@push('scripts')
    <!-- Date Picker -->
    <script type="text/javascript"
            src="{{ asset('vendor/AdminLTE/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- File Input -->
    <script type="text/javascript" src="{{ asset('vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>

    <script>
        $('.date-picker').datepicker({
            format: 'yyyy-mm-dd',
            endDate: '0d',
            autoclose: true
        });
    </script>
@endpush
