@extends('layouts.admin')

{{-- Styles --}}
@push('styles')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/AdminLTE/plugins/datatables/dataTables.bootstrap.min.css') }}">
@endpush

{{-- Web site Title --}}
@section('title', __('admin/user/title.user_management'))

{{-- Content Header --}}
@section('header')
    @lang('admin/user/title.user_management')
    <small>@lang('admin/user/title.user_management_desc')</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> @lang('admin/site.dashboard')
        </a>
    </li>
    <li class="active">
        <a href="{{ route('admin.users.index') }}">
            @lang('admin/site.users')
        </a>
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    <!-- actions -->
    <a href="{{ route('admin.users.create') }}">
        <button type="button" class="btn btn-success margin-bottom">
            <i class="fa fa-plus"></i> @lang('admin/user/title.create_a_new_user')
        </button>
    </a>
    <!-- /.actions -->

    <div class="box">
        <div class="box-body">
            <table id="users" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th class="col-md-2">@lang('admin/user/model.username')</th>
                    <th class="col-md-4">@lang('admin/user/model.name')</th>
                    <th class="col-md-3">@lang('admin/user/model.email')</th>
                    <th class="col-md-1">@lang('admin/user/model.role')</th>
                    <th class="col-md-2">@lang('general.actions')</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th class="col-md-2">@lang('admin/user/model.username')</th>
                    <th class="col-md-4">@lang('admin/user/model.name')</th>
                    <th class="col-md-3">@lang('admin/user/model.email')</th>
                    <th class="col-md-1">@lang('admin/user/model.role')</th>
                    <th class="col-md-2">@lang('general.actions')</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

{{-- Scripts --}}
@push('scripts')
    <script type="text/javascript"
            src="{{ asset('vendor/AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('vendor/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

    <script>
        $(function () {
            $('#users').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/@lang('site.dataTablesLang').json"
                },
                "ajax": "{{ route('admin.users.data') }}",
                "columns": [
                    {data: "username"},
                    {data: "name"},
                    {data: "email"},
                    {data: "role"},
                    {data: "actions", "orderable": false, "searchable": false}
                ],
                "aLengthMenu": [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "@lang('general.all')"]
                ],
                // set the initial value
                "iDisplayLength": 10
            });
        });
    </script>
@endpush
