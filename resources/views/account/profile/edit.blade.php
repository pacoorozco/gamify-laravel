@extends('layouts.master')

{{-- Web site Title --}}
@section('title', __('user/profile.edit_account'))

{{-- Content Header --}}
@section('header')
    {{ __('user/profile.edit_account') }}
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">
            {{ __('site.home') }}
        </a>
    </li>

    <li class="breadcrumb-item">
        <a href="{{ route('account.index') }}">
            {{ __('site.my_profile') }}
        </a>
    </li>

    <li class="breadcrumb-item active">
        {{ __('user/profile.edit_account') }}
    </li>
@endsection

{{-- Content --}}
@section('content')
    <div class="card">
        <div class="card-body">

            <x-forms.form :action="route('account.profile.update')"
                          method="PUT"
                          hasFiles>

                <div class="row">
                    <div class="col-md-6">

                        <!-- username -->
                        <x-forms.input
                            name="username"
                            :label="__('user/profile.username')"
                            :value="$user->username"
                            :readonly="true"/>
                        <!-- /.username -->

                        <!-- email -->
                        <x-forms.input
                            name="email"
                            :label="__('user/profile.email')"
                            :value="$user->email"
                            :readonly="true"/>
                        <!-- /.email -->

                        <!-- name -->
                        <x-forms.input
                            name="name"
                            :label="__('user/profile.name')"
                            :value="$user->name"
                            :required="true"/>
                        <!-- /.name -->

                        <!-- date_of_birth -->
                        <x-forms.date-time-picker
                            id="date_of_birth"
                            name="date_of_birth"
                            :label="__('user/profile.date_of_birth')"
                            :value="$user->profile->date_of_birth"
                            :required="true"
                            :placeholder="__('user/profile.date_of_birth_placeholder')"
                            :isDisabledTimepicker="true"/>
                        <!-- /.date_of_birth -->

                    </div>
                    <div class="col-md-6">

                        <!-- avatar -->
                        <x-forms.input-image
                            name="avatar"
                            :label="__('user/profile.image')"
                            :value="$user->profile->avatarUrl"
                            :help="__('user/profile.image_help')"/>
                        <!-- /.avatar -->

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                    <x-forms.legend>
                        {{ __('user/profile.additional_info') }}
                    </x-forms.legend>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">

                        <!-- twitter -->
                        <x-forms.input
                            name="twitter"
                            :label="__('user/profile.twitter')"
                            :value="$user->profile->twitter"
                            prepend='<i class="bi bi-twitter-x"></i>'/>
                        <!-- /.twitter -->

                        <!-- facebook -->
                        <x-forms.input
                            name="facebook"
                            :label="__('user/profile.facebook')"
                            :value="$user->profile->facebook"
                            prepend='<i class="bi bi-facebook"></i>'/>
                        <!-- /.facebook -->

                    </div>
                    <div class="col-md-6">

                        <!-- linkedin -->
                        <x-forms.input
                            name="linkedin"
                            :label="__('user/profile.linkedin')"
                            :value="$user->profile->linkedin"
                            prepend='<i class="bi bi-linkedin"></i>'/>
                        <!-- /.linkedin -->

                        <!-- github -->
                        <x-forms.input
                            name="github"
                            :label="__('user/profile.github')"
                            :value="$user->profile->github"
                            prepend='<i class="bi bi-github"></i>'/>
                        <!-- /.github -->

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <x-forms.textarea
                            name="bio"
                            label="{{ __('user/profile.bio') }}"
                            :value="$user->profile->bio"
                            rows="10" cols="50"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-right">
                        <x-forms.submit type="primary">
                            {{ __('button.save') }}
                        </x-forms.submit>
                    </div>
                </div>

            </x-forms.form>

        </div>
        <!-- /.box-body -->
    </div>
@endsection

@push('styles')
    <!-- File Input -->
    <link rel="stylesheet" href="{{ asset('vendor/jasny-bootstrap/css/jasny-bootstrap.min.css') }}">
@endpush

{{-- Scripts --}}
@push('scripts')
    <!-- File Input -->
    <script type="text/javascript"
            src="{{ asset('vendor/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script>
@endpush


