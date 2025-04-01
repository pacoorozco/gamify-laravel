@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ __('admin/user/title.create_a_new_user') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    {{ __('admin/user/title.create_a_new_user') }}
    <small>add a new user</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li>
        <a href="{{ route('admin.users.index') }}">
            {{ __('admin/site.users') }}
        </a>
    </li>
    <li class="active">
        {{ __('admin/user/title.create_a_new_user') }}
    </li>
@endsection


{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    {{-- Create / Edit User Form --}}
    <x-forms.form method="post" :action="route('admin.users.store')">

        <div class="box box-solid">
            <div class="box-body">
                <div class="row">

                    <!-- right column -->
                    <div class="col-md-6">
                        <!-- username -->
                        <x-forms.input name="username" :label="__('admin/user/model.username')" :required="true"/>
                        <!-- ./ username -->

                        <!-- name -->
                        <x-forms.input name="name" :label="__('admin/user/model.name')" :required="true"/>
                        <!-- ./ name -->

                        <!-- Email -->
                        <x-forms.input name="email" type="email" :label="__('admin/user/model.email')" :required="true"/>
                        <!-- ./ email -->

                    </div>
                    <!-- ./left column -->

                    <!-- right column -->
                    <div class="col-md-6">

                        <!-- role -->
                        <x-forms.select name='role'
                                        :label="__('admin/user/model.role')"
                                        :help="__('admin/user/messages.roles_help')"
                                        :options="\Gamify\Enums\Roles::options()"
                                        :required="true"/>
                        <!-- ./ role -->

                    </div>
                    <!-- ./right column -->

                </div>
            </div>

            <div class="box-footer">
                <!-- form actions -->
                <x-forms.submit class="btn btn-success" :value="__('button.save')" />

                <a href="{{ route('admin.users.index') }}" class="btn btn-link" role="button">
                    {{ __('general.back') }}
                </a>
                <!-- ./ form actions -->
            </div>

        </div>
    </x-forms.form>

@endsection
