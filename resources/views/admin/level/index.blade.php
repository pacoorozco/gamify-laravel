@extends('layouts.admin')

{{-- Styles --}}
@section('styles')
    {!! HTML::style('vendor/AdminLTE/plugins/datatables/dataTables.bootstrap.css') !!}
@endsection

{{-- Web site Title --}}
@section('title')
    {{ trans('admin/level/title.level_management') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    {{ trans('admin/level/title.level_management') }}
    <small>create and edit levels</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin-home') }}">
            <i class="fa fa-dashboard"></i> {{ trans('admin/site.dashboard') }}
        </a>
    </li>
    <li class="active">
        <a href="{{route('admin.levels.index') }}">
            {{ trans('admin/site.levels') }}
        </a>
    </li>
    @endsection


    {{-- Content --}}
    @section('content')

            <!-- Notifications -->
    @include('partials.notifications')
            <!-- ./ notifications -->

    <!-- actions -->
    <a href="{{ route('admin.levels.create') }}">
        <button type="button" class="btn btn-success margin-bottom">
            <i class="fa fa-plus"></i> {{ trans('admin/level/title.create_a_new_level') }}
        </button>
    </a>
    <!-- /.actions -->
    <div class="box">
        <div class="box-body">
            <table id="levels" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th class="col-md-4">{{ trans('admin/level/model.name') }}</th>
                    <th class="col-md-4">{{ trans('admin/level/model.image') }}</th>
                    <th class="col-md-1">{{ trans('admin/level/model.amount_needed') }}</th>
                    <th class="col-md-1">{{ trans('admin/level/model.active') }}</th>
                    <th class="col-md-2">{{ trans('general.actions') }}</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th class="col-md-4">{{ trans('admin/level/model.name') }}</th>
                    <th class="col-md-4">{{ trans('admin/level/model.image') }}</th>
                    <th class="col-md-1">{{ trans('admin/level/model.amount_needed') }}</th>
                    <th class="col-md-1">{{ trans('admin/level/model.active') }}</th>
                    <th class="col-md-2">{{ trans('general.actions') }}</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

{{-- Scripts --}}
@section('scripts')
    {!! HTML::script('vendor/AdminLTE/plugins/datatables/jquery.dataTables.min.js') !!}
    {!! HTML::script('vendor/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js') !!}

    <script>
        $(document).ready(function () {
            oTable = $('#levels').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/{{ trans('site.dataTablesLang') }}.json"
                },
                "ajax": "{{ route('admin.levels.data') }}",
                "columns": [
                    {data: "name"},
                    {data: "image", "orderable": false, "searchable": false},
                    {data: "amount_needed"},
                    {data: "active"},
                    {data: "actions", "orderable": false, "searchable": false}
                ],
                "aLengthMenu": [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "{{ trans('general.all') }}"]
                ],
                // set the initial value
                "iDisplayLength": 10
            });
        });
    </script>
@endsection