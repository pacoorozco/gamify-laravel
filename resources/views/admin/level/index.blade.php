@extends('layouts.admin')

{{-- Styles --}}
@push('styles')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.css') }}">
@endpush

{{-- Web site Title --}}
@section('title', __('admin/level/title.level_management'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/level/title.level_management') }}
    <small class="text-muted">{{ __('admin/level/title.level_management_desc') }}</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.home') }}">
            {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        {{ __('admin/site.levels') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    <!-- actions -->
    <div class="mb-3">
        <a href="{{ route('admin.levels.create') }}">
            <button type="button" class="btn btn-success margin-bottom">
                <i class="bi bi-plus-circle"></i> {{ __('admin/level/title.create_a_new_level') }}
            </button>
        </a>
    </div>
    <!-- /.actions -->
    <div class="card">
        <div class="card-body">
            <table id="levels" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th class="col-md-7">{{ __('admin/level/model.name') }}</th>
                    <th class="col-md-1">{{ __('admin/level/model.image') }}</th>
                    <th class="col-md-1">{{ __('admin/level/model.required_points') }}</th>
                    <th class="col-md-1">{{ __('admin/level/model.active') }}</th>
                    <th class="col-md-2">{{ __('general.actions') }}</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th class="col-md-7">{{ __('admin/level/model.name') }}</th>
                    <th class="col-md-1">{{ __('admin/level/model.image') }}</th>
                    <th class="col-md-1">{{ __('admin/level/model.required_points') }}</th>
                    <th class="col-md-1">{{ __('admin/level/model.active') }}</th>
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
            $('#levels').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/{{ __('site.dataTablesLang') }}.json"
                },
                "ajax": "{{ route('admin.levels.data') }}",
                "columns": [
                    {data: "name"},
                    {data: "image", "orderable": false, "searchable": false},
                    {data: "required_points"},
                    {data: "active"},
                    {data: "actions", "orderable": false, "searchable": false}
                ],
                "order": [[2, "asc"]],
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
