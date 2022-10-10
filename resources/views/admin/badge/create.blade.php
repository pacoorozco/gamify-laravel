@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/badge/title.create_a_new_badge'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/badge/title.create_a_new_badge') }}
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li>
        <a href="{{ route('admin.badges.index') }}">
            {{ __('admin/site.badges') }}
        </a>
    </li>
    <li class="active">
        {{ __('admin/badge/title.create_a_new_badge') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    {{-- Edit Badge Form --}}
    {!! Form::open(['route' => 'admin.badges.store', 'method' => 'post', 'files' => true]) !!}

    <div class="box box-solid">
        <div class="box-body">
            <div class="row">

                <!-- right column -->
                <div class="col-md-6">

                    <fieldset>
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
                    </fieldset>

                    <fieldset>
                        <!-- required_repetitions -->
                        <div class="form-group {{ $errors->has('required_repetitions') ? 'has-error' : '' }}">
                            {!! Form::label('required_repetitions', __('admin/badge/model.required_repetitions'), ['class' => 'control-label required']) !!}
                            <div class="controls">
                                {!! Form::number('required_repetitions', null, ['class' => 'form-control', 'required' => 'required', 'min' => '1']) !!}
                                <p class="text-muted">{{ __('admin/badge/model.required_repetitions_help') }}</p>
                                <span class="help-block">{{ $errors->first('required_repetitions', ':message') }}</span>

                            </div>
                        </div>
                        <!-- ./ required_repetitions -->

                        <!-- actuators -->
                        <div class="form-group {{ $errors->has('actuators') ? 'has-error' : '' }}">
                            {!! Form::label('actuators', __('admin/badge/model.actuators'), ['class' => 'control-label']) !!}
                            <div class="controls">
                                {!! Form::select('actuators', \Gamify\Enums\BadgeActuators::toSelectArray(), null, ['class' => 'form-control', 'required' => 'required']) !!}
                                <p class="text-muted">{{ __('admin/badge/model.actuators_help') }}</p>
                                <span class="help-block">{{ $errors->first('actuators', ':message') }}</span>
                            </div>
                        </div>
                        <!-- ./ actuators -->

                        <!-- tags -->
                        <div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}" id="tags-selector">
                            {!! Form::label('tags', __('admin/badge/model.tags'), ['class' => 'control-label']) !!}
                            <div class="controls">
                                <x-tags.form-select-tags name="tags"
                                                         :placeholder="__('admin/badge/model.tags_placeholder')"
                                                         :selected-tags="old('tags', [])"
                                                         class="form-control"
                                />
                                <p class="text-muted">{{ __('admin/badge/model.tags_help') }}</p>
                            </div>
                        </div>
                        <!-- ./ tags -->
                    </fieldset>

                </div>
                <!-- ./left column -->

                <!-- right column -->
                <div class="col-md-6">

                    <!-- image -->
                    <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                        {!! Form::label('image', __('admin/badge/model.image'), ['class' => 'control-label required']) !!}
                        <p class="text-muted">{{ __('admin/badge/model.image_help') }}</p>
                        <div class="controls">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new">
                                    <img src="{{ asset('images/missing_badge.png') }}" class="img-thumbnail"
                                         style="width: 150px; height: 150px;" alt="default image">
                                </div>
                                <div class="fileinput-preview fileinput-exists img-thumbnail"
                                     style="max-width: 150px; max-height: 150px;">
                                </div>

                                <!-- image buttons -->
                                <div class="clearfix">

                                <span class="btn btn-default btn-file">
                                    <span class="fileinput-new">
                                        <i class="fa fa-picture-o"></i> {{ __('button.pick_image') }}
                                    </span>
                                    <span class="fileinput-exists">
                                        <i class="fa fa-picture-o"></i> {{ __('button.upload_image') }}
                                    </span>
                                    <input type="file" name="image">
                                </span>
                                    <a href="#" class="fileinput-exists btn btn-default" data-dismiss="fileinput" role="button">
                                        <i class="fa fa-times"></i> {{ __('button.delete_image') }}
                                    </a>

                                </div>
                                <!-- ./image buttons -->

                            </div>
                        </div>
                        <span class="help-block">{{ $errors->first('image', ':message') }}</span>
                    </div>
                    <!-- ./ image -->

                    <!-- status -->
                    <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">
                        {!! Form::label('active', __('admin/badge/model.active'), ['class' => 'control-label required']) !!}
                        <div class="controls">
                            {!! Form::select('active', ['1' => __('general.yes'), '0' => __('general.no')], null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <span class="help-block">{{ $errors->first('active', ':message') }}</span>
                        </div>
                    </div>
                    <!-- ./status -->

                </div>
                <!-- ./right column -->

            </div>
        </div>

        <div class="box-footer">
            <!-- form actions -->
            {!! Form::button(__('button.save'), ['type' => 'submit', 'class' => 'btn btn-success']) !!}
            <a href="{{ route('admin.badges.index') }}" class="btn btn-link" role="button">
                {{ __('general.back') }}
            </a>
            <!-- ./ form actions -->
        </div>

    </div>
    {!! Form::close() !!}

@endsection

{{-- Styles --}}
@push('styles')
    <link rel="stylesheet"
          href="{{ asset('vendor/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
@endpush

{{-- Scripts --}}
@push('scripts')
    <script
        src="{{ asset('vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>

    <script>
        $(function () {

            $('#actuators').change(function () {
                $(this).find("option:selected").each(function () {
                    let optionValue = parseInt($(this).attr("value"));
                    if (isTaggable(optionValue)) {
                        enableTags();
                    } else {
                        disableTags();
                    }
                });
            }).change();

            function isTaggable(value) {
                return !($.inArray(value, [{{ \Gamify\Enums\BadgeActuators::triggeredByQuestionsList() }}]) === -1);
            }

            function enableTags() {
                $('#tags-selector').show();
                $('#tags').prop('disabled', false)
            }

            function disableTags() {
                $('#tags-selector').hide();
                $('#tags').prop('disabled', true)
            }

        });
    </script>
@endpush
