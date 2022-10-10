@extends('layouts.admin')

{{-- Styles --}}
@push('styles')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/AdminLTE/plugins/datatables/dataTables.bootstrap.css') }}">
@endpush

{{-- Web site Title --}}
@section('title', __('admin/badge/title.badge_management'))

{{-- Content Header --}}
@section('header')
    {{ __('admin/badge/title.badge_management') }}
    <small>{{ __('admin/badge/title.badge_management_desc') }}</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li class="active">
        {{ __('admin/site.badges') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    <!-- actions -->
    <a href="{{ route('admin.badges.create') }}" class="btn btn-success margin-bottom" role="button">
        <i class="fa fa-plus"></i> {{ __('admin/badge/title.create_a_new_badge') }}
    </a>
    <!-- /.actions -->
    <div class="box">
        <div class="box-body">
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
    <script src="{{ asset('vendor/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

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
