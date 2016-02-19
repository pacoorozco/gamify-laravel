{{-- Create / Edit Question Form --}}

@section('meta')
        <!-- Unobtrusive JavaScript -->
<meta name="csrf-token" content="{!! csrf_token() !!}">
<meta name="csrf-param" content="_token">
@endsection


@if (isset($question))
    {!! Form::model($question, array(
                'route' => array('admin.questions.update', $question),
                'method' => 'put',
                'files' => true
                )) !!}
@else
    {!! Form::open(array(
                'route' => array('admin.questions.store'),
                'method' => 'post',
                'files' => true
                )) !!}
@endif

<div class="row">
    <div class="col-xs-8">

        <div class="box box-solid">
            <div class="box-body">
                <!-- name -->
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    {!! Form::label('name', trans('admin/question/model.name'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::text('name', null, array('class' => 'form-control')) !!}
                        <span class="help-block">{{ $errors->first('name', ':message') }}</span>
                    </div>
                </div>
                <!-- ./ name -->

                <!-- question -->
                <div class="form-group {{ $errors->has('question') ? 'has-error' : '' }}">
                    {!! Form::label('question', trans('admin/question/model.question'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::textarea('question', null, array('class' => 'form-control tinymce')) !!}
                        <span class="help-block"><i
                                    class="fa fa-info-circle"></i> Users will see this text as a question.</span>
                        <span class="help-block">{{ $errors->first('question', ':message') }}</span>
                    </div>
                </div>
                <!-- ./ question -->


                <!-- type -->
                <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                    {!! Form::label('type', trans('admin/question/model.type'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        {!! Form::select('type', array('single' => trans('admin/question/model.single'), 'multi' => trans('admin/question/model.multi')), 'single', array('class' => 'form-control')) !!}
                        {{ $errors->first('type', '<span class="help-inline">:message</span>') }}
                    </div>
                </div>
                <!-- ./ type -->

                <!-- answers -->
                @if (isset($question))
                    @include('admin/question/_form_choices')
                @else
                    <div class="callout callout-info">
                        <h4>NOTE!</h4>

                        <p>After saving this question you will be able to add some answer choices.</p>
                    </div>
                    @endif
                            <!-- ./ answers -->

                    <!-- solution -->
                    <div class="form-group {{ $errors->has('solution') ? 'has-error' : '' }}">
                        {!! Form::label('solution', trans('admin/question/model.solution'), array('class' => 'control-label')) !!}
                        <div class="controls">
                            {!! Form::textarea('solution', null, array('class' => 'form-control tinymce')) !!}
                            <span class="help-block"><i class="fa fa-info-circle"></i> Users will see this text once they have answered.</span>
                            <span class="help-block">{{ $errors->first('solution', ':message') }}</span>
                        </div>
                    </div>
                    <!-- ./ solution -->
            </div>
        </div>
    </div>


    <div class="col-xs-4">

        <!-- publish -->
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Publish</h3>
            </div>
            <div class="box-body">
                <!-- status -->
                @if (isset($question))
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                        {!! Form::label('status', trans('admin/question/model.status'), array('class' => 'control-label')) !!}
                        <div class="controls">
                            {!! Form::select('status', array('draft' => trans('admin/question/model.draft'), 'publish' => trans('admin/question/model.publish'), 'unpublish' => trans('admin/question/model.unpublish')), null, array('class' => 'form-control')) !!}
                            {{ $errors->first('status', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>
                    @else
                    {!! Form::hidden('status','draft') !!}
                    @endif
                            <!-- ./ status -->

                    <!-- hidden -->
                    <div class="form-group {{ $errors->has('hidden') ? 'has-error' : '' }}">
                        {!! Form::label('hidden', trans('admin/question/model.hidden'), array('class' => 'control-label')) !!}
                        <div class="controls">
                            {!! Form::select('hidden', array('0' => trans('admin/question/model.hidden_no'), '1' => trans('admin/question/model.hidden_yes')), null, array('class' => 'form-control')) !!}
                            <p class="help-block">Hidden questions will not be visible on question's list.<br/>They only
                                can
                                access via direct URL.</p>
                            {{ $errors->first('hidden', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>
                    <!-- ./ hidden -->
            </div>
            <div class="box-footer">
                <!-- form actions -->
                <a href="{{ route('admin.questions.index') }}">
                    <button type="button" class="btn btn-primary">
                        <i class="fa fa-arrow-left"></i> {{ trans('general.back') }}
                    </button>
                </a>
                {!! Form::button(trans('button.save'), array('type' => 'submit', 'class' => 'btn btn-success')) !!}
                        <!-- ./ form actions -->
            </div>

        </div><!-- ./ box -->
        <!-- ./ publish -->

        <!-- image -->
        <div class="box box-solid collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('admin/question/model.image') }}</h3>

                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <p>TODO: Not yet implemented!</p>
                {{--
                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                    {!! Form::label('image', trans('admin/question/model.image'), array('class' => 'control-label')) !!}
                    <div class="controls">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 150px; height: 150px;">
                                @if (isset($question))
                                    <img src='{{ $question->image->url('big') }}' class='file-preview-image'/>
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
                        <span class="help-block"><i class="fa fa-info-circle"></i> Image will be used as 220px, 128px and 64px squared sizes.</span>
                        <span class="help-block">{{ $errors->first('image', ':message') }}</span>
                    </div>
                </div>
                --}}
            </div><!-- ./ box-body -->
        </div><!-- ./ box -->
        <!-- ./ image -->

        <!-- actions -->
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('admin/question/model.actions') }}</h3>

                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                @if (isset($question))
                    @include('admin/question/_form_actions')
                @else
                    <div class="callout callout-info">
                        <h4>NOTE!</h4>

                        <p>After saving this question you will be able to add some actions.</p>
                    </div>
                @endif
            </div>
        </div>
        <!-- ./ actions -->
    </div>
</div><!-- ./ row -->

{!! Form::close() !!}

{{-- Styles --}}
@section('styles')
        <!-- File Input -->
{{-- HTML::style(Theme::url('plugins/bootstrap-fileupload/bootstrap-fileupload.min.css')) --}}
@endsection

{{-- Scripts --}}
@section('scripts')
        <!-- TinyMCE -->
{!! HTML::script('//tinymce.cachefly.net/4.0/tinymce.min.js') !!}
        <!-- jQuery UJS -->
{!! HTML::script('vendor/jquery-ujs/src/rails.js') !!}
        <!-- File Input -->
{{-- HTML::script(Theme::url('plugins/bootstrap-fileupload/bootstrap-fileupload.min.js')) --}}
<script type="text/javascript">
    tinymce.init({
        selector: "textarea.tinymce",
        width: '100%',
        height: 270,
        statusbar: false,
        menubar: false,
        plugins: [
            "link",
            "code"
        ],
        toolbar: "bold italic underline strikethrough | removeformat | undo redo | bullist numlist | link code"
    });
</script>
@endsection