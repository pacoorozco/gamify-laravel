@extends('layouts.admin')

{{-- Styles --}}
@push('styles')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/AdminLTE/plugins/datatables/dataTables.bootstrap.css') }}">
@endpush

{{-- Web site Title --}}
@section('title')
    @lang('admin/badge/title.badge_management') :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    @lang('admin/badge/title.badge_management')
    <small>create and edit badges</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> @lang('admin/site.dashboard')
        </a>
    </li>
    <li class="active">
        @lang('admin/site.badges')
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- ./ notifications -->

    <!-- actions -->
    <a href="{{ route('admin.badges.create') }}">
        <button type="button" class="btn btn-success margin-bottom">
            <i class="fa fa-plus"></i> @lang('admin/badge/title.create_a_new_badge')
        </button>
    </a>
    <!-- /.actions -->
    <div class="box">
        <div class="box-body">
            <table id="badges" class="table table-striped table-bordered table-hover table-full-width">
                <thead>
                <tr>
                    <th class="col-md-4">@lang('admin/badge/model.name')</th>
                    <th class="col-md-4">@lang('admin/badge/model.image')</th>
                    <th class="col-md-1">@lang('admin/badge/model.required_repetitions')</th>
                    <th class="col-md-1">@lang('admin/badge/model.active')</th>
                    <th class="col-md-2">@lang('general.actions')</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th class="col-md-4">@lang('admin/badge/model.name')</th>
                    <th class="col-md-4">@lang('admin/badge/model.image')</th>
                    <th class="col-md-1">@lang('admin/badge/model.required_repetitions')</th>
                    <th class="col-md-1">@lang('admin/badge/model.active')</th>
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
            $('#badges').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/@lang('site.dataTablesLang').json"
                },
                "ajax": "{{ route('admin.badges.data') }}",
                "columns": [
                    {data: "name"},
                    {data: "image", "orderable": false, "searchable": false},
                    {data: "required_repetitions"},
                    {data: "active"},
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
