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

        <!-- tags -->
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('admin/question/model.tags') }}</h3>

                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                {!! Form::label('tag_list', trans('admin/question/model.tags'), ['class' => 'control-label']) !!}
                {!! Form::select('tag_list[]', $availableTags, null, ['class' => 'form-control tags-input', 'multiple' => 'multiple']) !!}
            </div>
        </div>
        <!-- ./ tags -->

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
        <!-- Select2 -->
{!! HTML::style('vendor/select2/dist/css/select2.min.css') !!}
{!! HTML::style('vendor/select2-bootstrap-theme/dist/select2-bootstrap.min.css') !!}
@endsection

{{-- Scripts --}}
@section('scripts')
        <!-- TinyMCE -->
{!! HTML::script('//cdn.tinymce.com/4/tinymce.min.js') !!}
        <!-- jQuery UJS -->
{!! HTML::script('vendor/jquery-ujs/src/rails.js') !!}
        <!-- Select2 -->
{!! HTML::script('vendor/select2/dist/js/select2.min.js') !!}

<script>
    $(function () {
        $(".tags-input").select2({
            tags: true,
            placeholder: 'Put your tags here',
            tokenSeparators: [','],
            allowClear: true,
            theme: "bootstrap",
            matcher: function(params, data) {
                // If there are no search terms, return all of the data
                if ($.trim(params.term) === '') {
                    return data;
                }

                // `params.term` should be the term that is used for searching
                // `data.text` is the text that is displayed for the data object
                if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) > -1) {
                    return data;
                }

                // Return `null` if the term should not be displayed
                return null;
            },
            createTag: function(params) {
                var term = $.trim(params.term);
                if(term === "") { return null; }

                var optionsMatch = false;

                this.$element.find("option").each(function() {
                    if(this.value.toLowerCase().indexOf(term.toLowerCase()) > -1) {
                        optionsMatch = true;
                    }
                });

                if(optionsMatch) {
                    return null;
                }
                return {id: term, text: term};
            }
        });
    });
</script>
@endsection