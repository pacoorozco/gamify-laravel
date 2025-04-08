@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/level/title.create_a_new_level'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/level/title.create_a_new_level') }}
    <small>{{ __('admin/level/title.create_a_new_level_desc') }}</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="bi bi-house-fill"></i> {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li>
        <a href="{{ route('admin.levels.index') }}">
            {{ __('admin/site.levels') }}
        </a>
    </li>
    <li class="active">
        {{ __('admin/level/title.create_a_new_level') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    <x-forms.form method="post" :action="route('admin.levels.store')" hasFiles>

        <div class="box box-solid">
            <div class="box-body">
                <div class="row">

                    <!-- right column -->
                    <div class="col-md-6">

                        <!-- name -->
                        <x-forms.input name="name" :label="__('admin/level/model.name')" :required="true"/>
                        <!-- ./ name -->

                        <!-- required_points -->
                        <x-forms.input type="number" name="required_points"
                                       :label="__('admin/level/model.required_points')"
                                       min="0"
                                       value="0"
                                       :required="true"/>
                        <!-- ./ required_points -->

                        <!-- activation status -->
                        <x-forms.select name='active'
                                        :label="__('admin/level/model.active')"
                                        :options="['1' => __('general.yes'), '0' => __('general.no')]"
                                        selectedKey="1"
                                        :required="true"/>
                        <!-- ./ activation status -->

                    </div>
                    <!-- ./left column -->

                    <!-- right column -->
                    <div class="col-md-6">

                        <!-- image -->
                        <x-forms.input-group :hasError="$errors->has('image')">
                            <x-forms.label for="image" :value="__('admin/level/model.image')"/>
                            <p class="text-muted">{{ __('admin/badge/model.image_help') }}</p>
                            <div class="controls">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                         style="width: 150px; height: 150px;">
                                    </div>
                                    <p>
                            <span class="btn btn-default btn-file">
                                <span class="fileinput-new"><i
                                        class="bi bi-image"></i> {{ __('button.pick_image') }}</span>
                                <span class="fileinput-exists"><i
                                        class="bi bi-image"></i> {{ __('button.upload_image') }}</span>
                                <input type="file" name="image">
                            </span>
                                        <a href="#" class="btn fileinput-exists btn-default" data-dismiss="fileinput"
                                           role="button">
                                            <i class="bi bi-trash"></i> {{ __('button.delete_image') }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <span class="help-block">{{ $errors->first('image', ':message') }}</span>
                        </x-forms.input-group>
                        <!-- ./ image -->

                    </div>
                    <!-- ./right column -->

                </div>
            </div>

            <div class="box-footer">
                <!-- Form Actions -->
                <x-forms.submit type="success" :value="__('button.save')"/>

                <a href="{{ route('admin.levels.index') }}" class="btn btn-link" role="button">
                    {{ __('general.back') }}
                </a>
                <!-- ./ form actions -->
            </div>

        </div>
    </x-forms.form>

@endsection

{{-- Styles --}}
@push('styles')
    <!-- File Input -->
    <link rel="stylesheet" href="{{ asset('vendor/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
@endpush

{{-- Scripts --}}
@push('scripts')
    <!-- File Input -->
    <script type="text/javascript" src="{{ asset('vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
@endpush


