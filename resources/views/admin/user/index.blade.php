@extends('layouts.admin')

{{-- Styles --}}
@push('styles')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.css') }}">
@endpush

{{-- Web site Title --}}
@section('title', __('admin/user/title.user_management'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/user/title.user_management') }}
    <small class="text-muted">{{ __('admin/user/title.user_management_desc') }}</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.home') }}">
            {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        {{ __('admin/site.users') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    <!-- actions -->
    <div class="mb-3">
        <a href="{{ route('admin.users.create') }}">
            <button type="button" class="btn btn-success margin-bottom">
                <i class="bi bi-plus-circle"></i> {{ __('admin/user/title.create_a_new_user') }}
            </button>
        </a>
    </div>
    <!-- /.actions -->

    <div class="card">
        <div class="card-body">
            <table id="users" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th class="col-md-2">{{ __('admin/user/model.username') }}</th>
                    <th class="col-md-3">{{ __('admin/user/model.name') }}</th>
                    <th class="col-md-2">{{ __('admin/user/model.email') }}</th>
                    <th class="col-md-1">{{ __('admin/user/model.role') }}</th>
                    <th class="col-md-1">{{ __('user/profile.level') }}</th>
                    <th class="col-md-1">{{ __('user/profile.experience') }}</th>
                    <th class="col-md-2">{{ __('general.actions') }}</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th class="col-md-2">{{ __('admin/user/model.username') }}</th>
                    <th class="col-md-3">{{ __('admin/user/model.name') }}</th>
                    <th class="col-md-2">{{ __('admin/user/model.email') }}</th>
                    <th class="col-md-1">{{ __('admin/user/model.role') }}</th>
                    <th class="col-md-1">{{ __('user/profile.level') }}</th>
                    <th class="col-md-1">{{ __('user/profile.experience') }}</th>
                    <th class="col-md-2">{{ __('general.actions') }}</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

{{-- Scripts --}}
@push('scripts')
    <script src="{{ asset('vendor/AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script>
        $(function () {
            $('#users').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/{{ __('site.dataTablesLang') }}.json"
                },
                "ajax": "{{ route('admin.users.data') }}",
                "columns": [
                    {data: "username"},
                    {data: "name"},
                    {data: "email"},
                    {data: "role"},
                    {data: "level"},
                    {data: "experience"},
                    {data: "actions", "orderable": false, "searchable": false}
                ],
                "aLengthMenu": [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "{{ __('general.all') }}"]
                ],
                // set the initial value
                "iDisplayLength": 10,
                "autoWidth": false
            });
        });
    </script>
@endpush
