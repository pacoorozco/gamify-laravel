@extends('layouts.admin')

{{-- Styles --}}
@push('styles')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('vendor/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.css') }}">
@endpush

{{-- Web site Title --}}
@section('title')
    {{ __('admin/question/title.question_management') }} @parent
@endsection

{{-- Content Header --}}
@section('header')
    {{ __('admin/question/title.question_management') }}
    <small class="text-muted">create and edit questions</small>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.home') }}">
            {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ route('admin.questions.index') }}">
            {{ __('admin/site.questions') }}
        </a>
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- notifications -->
    @include('partials.notifications')
    <!-- /.notifications -->

    <!-- actions -->
    <div class="mb-3">
    <a href="{{ route('admin.questions.create') }}">
        <button type="button" class="btn btn-success margin-bottom">
            <i class="bi bi-plus-circle"></i> {{ __('admin/question/title.create_a_new_question') }}
        </button>
    </a>
    </div>
    <!-- /.actions -->
    <div class="card">
        <div class="card-body">
            <table id="questions" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="col-md-4">{{ __('admin/question/model.name') }}</th>
                    <th class="col-md-3">{{ __('admin/question/model.tags') }}</th>
                    <th class="col-md-1">{{ __('admin/question/model.status') }}</th>
                    <th class="col-md-2">{{ __('admin/question/model.publication_date') }}</th>
                    <th class="col-md-2">{{ __('general.actions') }}</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th class="col-md-4">{{ __('admin/question/model.name') }}</th>
                    <th class="col-md-3">{{ __('admin/question/model.tags') }}</th>
                    <th class="col-md-1">{{ __('admin/question/model.status') }}</th>
                    <th class="col-md-2">{{ __('admin/question/model.publication_date') }}</th>
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
            $('#questions').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/{{ __('site.dataTablesLang') }}.json"
                },
                "ajax": "{{ route('admin.questions.data') }}",
                "columns": [
                    {data: "name"},
                    {data: "tags"},
                    {data: "status"},
                    {data: "publication_date"},
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
