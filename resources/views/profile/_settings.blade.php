{!! Form::model($user->profile, array(
                                'url' => 'user/' . $user->username,
                                'method' => 'post',
                                'files' => true,
                                'role' => 'form',
                    )) !!}
<div class="col-md-6">
    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
        {!! Form::label('name', trans('user/profile.fullname'), array('class' => 'control-label')) !!}
        <div class="controls">
            {!! Form::text('name', $user->name, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
        </div>
    </div>
    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
        {!! Form::label('email', trans('user/profile.email'), array('class' => 'control-label')) !!}
        <div class="controls">
            {!! Form::email('email', $user->email, array('class' => 'form-control', 'disabled' => 'disabled')) !!}
            <span class="help-block">{{ $errors->first('email', ':message') }}</span>
        </div>
    </div>
    <div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
        {!! Form::label('url', trans('user/profile.url'), array('class' => 'control-label')) !!}
        <div class="controls">
            {!! Form::text('url', null, array('class' => 'form-control')) !!}
            <span class="help-block">{{ $errors->first('url', ':message') }}</span>
        </div>
    </div>
    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
        {!! Form::label('phone', trans('user/profile.phone'), array('class' => 'control-label')) !!}
        <div class="controls">
            {!! Form::text('phone', null, array('class' => 'form-control')) !!}
            <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
        </div>
    </div>
    <div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
        {!! Form::label('mobile', trans('user/profile.mobile'), array('class' => 'control-label')) !!}
        <div class="controls">
            {!! Form::text('mobile', null, array('class' => 'form-control')) !!}
            <span class="help-block">{{ $errors->first('mobile', ':message') }}</span>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group {{ $errors->has('date_of_birth') ? 'has-error' : '' }}">
        {!! Form::label('date_of_birth', trans('user/profile.date_of_birth'), array('class' => 'control-label')) !!}
        <div class="controls">
            <div class="input-group">
                {!! Form::text('date_of_birth', null, array('class' => 'form-control date-picker')) !!}
                <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
            </div>
            <span class="help-block">{{ $errors->first('date_of_birth', ':message') }}</span>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('gender', trans('user/profile.gender'), array('class' => 'control-label')) !!}
        <div>
            <label class="radio-inline">
                {!! Form::radio('gender', 'female', null, array('class' => 'grey')) !!}
                {{ trans('user/profile.gender_female') }}
            </label>
            <label class="radio-inline">
                {!! Form::radio('gender', 'male', null, array('class' => 'grey')) !!}
                {{ trans('user/profile.gender_male') }}
            </label>
            <label class="radio-inline">
                {!! Form::radio('gender', 'unspecified', null, array('class' => 'grey')) !!}
                {{ trans('user/profile.gender_unspecified') }}
            </label>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('image', trans('user/profile.image'), array('class' => 'control-label')) !!}
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="fileupload-new thumbnail" style="width: 150px; height: 150px;">
                <img src="{{ $user->profile->avatar->url('medium') }}">
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
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <h3>{{ trans('user/profile.additional_info') }}</h3>
        <hr>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('twitter') ? 'has-error' : '' }}">
            {!! Form::label('twitter', trans('user/profile.twitter'), array('class' => 'control-label')) !!}
            <div class="controls">
                <span class="input-icon">
                {!! Form::text('twitter', null, array('class' => 'form-control')) !!}
                    <i class="clip-twitter"></i> </span>
                <span class="help-block">{{ $errors->first('twitter', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('facebook') ? 'has-error' : '' }}">
            {!! Form::label('facebook', trans('user/profile.facebook'), array('class' => 'control-label')) !!}
            <div class="controls">
                <span class="input-icon">
                {!! Form::text('facebook', null, array('class' => 'form-control')) !!}
                    <i class="clip-facebook"></i> </span>
                <span class="help-block">{{ $errors->first('facebook', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('googleplus') ? 'has-error' : '' }}">
            {!! Form::label('googleplus', trans('user/profile.googleplus'), array('class' => 'control-label')) !!}
            <div class="controls">
                <span class="input-icon">
                {!! Form::text('googleplus', null, array('class' => 'form-control')) !!}
                    <i class="clip-google-plus"></i> </span>
                <span class="help-block">{{ $errors->first('googleplus', ':message') }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('github') ? 'has-error' : '' }}">
            {!! Form::label('github', trans('user/profile.github'), array('class' => 'control-label')) !!}
            <div class="controls">
                <span class="input-icon">
                {!! Form::text('github', null, array('class' => 'form-control')) !!}
                    <i class="clip-github-2"></i> </span>
                <span class="help-block">{{ $errors->first('github', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('linkedin') ? 'has-error' : '' }}">
            {!! Form::label('linkedin', trans('user/profile.linkedin'), array('class' => 'control-label')) !!}
            <div class="controls">
                <span class="input-icon">
                {!! Form::text('linkedin', null, array('class' => 'form-control')) !!}
                    <i class="clip-linkedin"></i> </span>
                <span class="help-block">{{ $errors->first('linkedin', ':message') }}</span>
            </div>
        </div>
        <div class="form-group {{ $errors->has('skype') ? 'has-error' : '' }}">
            {!! Form::label('skype', trans('user/profile.skype'), array('class' => 'control-label')) !!}
            <div class="controls">
                <span class="input-icon">
                {!! Form::text('skype', null, array('class' => 'form-control')) !!}
                    <i class="clip-skype"></i> </span>
                <span class="help-block">{{ $errors->first('skype', ':message') }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <p>&nbsp;</p>
    </div>
    <div class="col-md-4">
        {!! Form::button(trans('button.update'), array('type' => 'submit', 'class' => 'btn btn-teal btn-block')) !!}
    </div>
</div>
{!! Form::close() !!}


@section('styles')
    <!-- Date Picker -->
    {!! HTML::style('vendor/AdminLTE/plugins/datepicker/datepicker3.css') !!}
@endsection

{{-- Scripts --}}
@section('scripts')
    <!-- Date Picker -->
    {!! HTML::script('vendor/AdminLTE/plugins/datepicker/bootstrap-datepicker.js') !!}

<script type="text/javascript">
    $('.date-picker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });
</script>
@endsection