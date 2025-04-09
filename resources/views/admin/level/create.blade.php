@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/level/title.create_a_new_level'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/level/title.create_a_new_level') }}
    <small class="text-muted">{{ __('admin/level/title.create_a_new_level_desc') }}</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.home') }}">
            {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.levels.index') }}">
            {{ __('admin/site.levels') }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        {{ __('admin/level/title.create_a_new_level') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    <x-forms.form method="post" :action="route('admin.levels.store')" hasFiles>

        <div class="card">
            <div class="card-body">
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
                        <x-forms.input-image name="image"
                                             :label="__('admin/level/model.image')"
                                             :help="__('admin/badge/model.image_help')"
                                             :value="old('image')"/>
                        <!-- ./ image -->

                    </div>
                    <!-- ./right column -->

                </div>
            </div>

            <div class="card-footer">
                <!-- Form Actions -->
                <x-forms.submit type="primary" :value="__('general.create')"/>

                <a href="{{ route('admin.levels.index') }}" class="btn btn-link" role="button">
                    {{ __('general.cancel') }}
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


