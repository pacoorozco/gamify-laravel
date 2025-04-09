@extends('layouts.admin')

{{-- Styles --}}
@push('styles')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.css') }}">
@endpush

{{-- Web site Title --}}
@section('title', __('admin/badge/title.badge_management'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/badge/title.badge_management') }}
    <small class="text-muted">{{ __('admin/badge/title.badge_management_desc') }}</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.home') }}">
            <i class="bi bi-house-fill"></i> {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        {{ __('admin/site.badges') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    <!-- actions -->
    <div class="mb-3">
        <a href="{{ route('admin.badges.create') }}" class="btn btn-success margin-bottom" role="button">
            <i class="bi bi-plus-circle"></i> {{ __('admin/badge/title.create_a_new_badge') }}
        </a>
    </div>
    <!-- /.actions -->
    <div class="card">
        <div class="card-body">
            <table id="badges" class="table table-striped table-bordered table-hover table-full-width">
                <thead>
                <tr>
                    <th class="col-md-3">{{ __('admin/badge/model.name') }}</th>
                    <th class="col-md-1">{{ __('admin/badge/model.image') }}</th>
                    <th class="col-md-2">{{ __('admin/badge/model.actuators') }}</th>
                    <th class="col-md-2">{{ __('admin/badge/model.tags') }}</th>
                    <th class="col-md-1">{{ __('admin/badge/model.required_repetitions') }}</th>
                    <th class="col-md-1">{{ __('admin/badge/model.active') }}</th>
                    <th class="col-md-2">{{ __('general.actions') }}</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th class="col-md-3">{{ __('admin/badge/model.name') }}</th>
                    <th class="col-md-1">{{ __('admin/badge/model.image') }}</th>
                    <th class="col-md-2">{{ __('admin/badge/model.actuators') }}</th>
                    <th class="col-md-2">{{ __('admin/badge/model.tags') }}</th>
                    <th class="col-md-1">{{ __('admin/badge/model.required_repetitions') }}</th>
                    <th class="col-md-1">{{ __('admin/badge/model.active') }}</th>
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
            $('#badges').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/{{ __('site.dataTablesLang') }}.json"
                },
                "ajax": "{{ route('admin.badges.data') }}",
                "columns": [
                    {data: "name"},
                    {data: "image", "orderable": false, "searchable": false},
                    {data: "actuators"},
                    {data: "tags"},
                    {data: "required_repetitions"},
                    {data: "active"},
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
