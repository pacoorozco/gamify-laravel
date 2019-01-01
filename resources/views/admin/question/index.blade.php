@extends('layouts.admin')

{{-- Styles --}}
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/AdminLTE/plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

{{-- Web site Title --}}
@section('title')
    {{ trans('admin/question/title.question_management') }} @parent
@endsection

{{-- Content Header --}}
@section('header')
    {{ trans('admin/question/title.question_management') }}
    <small>create and edit questions</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> {{ trans('admin/site.dashboard') }}
        </a>
    </li>
    <li class="active">
        <a href="{{ route('admin.questions.index') }}">
            {{ trans('admin/site.questions') }}
        </a>
    </li>
    @endsection

    {{-- Content --}}
    @section('content')

            <!-- notifications -->
    @include('partials.notifications')
            <!-- /.notifications -->

    <!-- actions -->
    <a href="{{ route('admin.questions.create') }}">
        <button type="button" class="btn btn-success margin-bottom">
            <i class="fa fa-plus"></i> {{ trans('admin/question/title.create_a_new_question') }}
        </button>
    </a>
    <!-- /.actions -->
    <div class="box">
        <div class="box-body">
            <table id="questions" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="col-md-4">{{ trans('admin/question/model.shortname') }}</th>
                    <th class="col-md-4">{{ trans('admin/question/model.name') }}</th>
                    <th class="col-md-2">{{ trans('admin/question/model.status') }}</th>
                    <th class="col-md-2">{{ trans('general.actions') }}</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th class="col-md-4">{{ trans('admin/question/model.shortname') }}</th>
                    <th class="col-md-4">{{ trans('admin/question/model.name') }}</th>
                    <th class="col-md-2">{{ trans('admin/question/model.status') }}</th>
                    <th class="col-md-2">{{ trans('general.actions') }}</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

{{-- Scripts --}}
@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            oTable = $('#questions').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/{{ trans('site.dataTablesLang') }}.json"
                },
                "ajax": "{{ route('admin.questions.data') }}",
                "columns": [
                    {data: "shortname"},
                    {data: "name"},
                    {data: "status"},
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
