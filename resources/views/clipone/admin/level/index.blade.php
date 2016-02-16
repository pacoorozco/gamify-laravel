@extends('layouts.admin')

{{-- Styles --}}
@section('styles')
    {!! HTML::style('//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css') !!}
@endsection

{{-- Web site Title --}}
@section('title')
    {{ trans('admin/level/title.level_management') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
<h1>
    {{ trans('admin/level/title.level_management') }} <small>create and edit levels</small>
</h1>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
<li>
    <i class="fa fa-graduation-cap"></i>
    <a href="{{route('admin.levels.index') }}">
        {{ trans('admin/site.levels') }}
    </a>
</li>
<li class="active">
    {{ trans('admin/level/title.level_management') }}
</li>
@endsection


{{-- Content --}}
@section('content')

<!-- Notifications -->
@include('admin.partials.notifications')
<!-- ./ notifications -->

<!-- actions -->
<div class="row">
    <div class="col-md-12 space20">
        <a class="btn btn-green add-row" href="{{ route('admin.levels.create') }}">
            <i class="fa fa-plus"></i> {{ trans('admin/level/title.create_a_new_level') }}
        </a>
    </div>
</div>
<!-- /.actions -->

    <div class="row">
        <div class="col-xs-12">
            <table id="levels" class="table table-striped table-bordered table-hover table-full-width">
                <thead>
                <tr>
                    <th class="col-md-4">{{ trans('admin/level/model.name') }}</th>
                    <th class="col-md-4">{{ trans('admin/level/model.image') }}</th>
                    <th class="col-md-1">{{ trans('admin/level/model.amount_needed') }}</th>
                    <th class="col-md-1">{{ trans('admin/level/model.active') }}</th>
                    <th class="col-md-2">{{ trans('general.actions') }}</th>
                </tr>
                </thead>
            </table>
    </div>
</div>

@endsection

{{-- Scripts --}}
@section('scripts')
    {!! HTML::script('//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js') !!}
    {!! HTML::script('//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.min.js') !!}

    <script>
        $(document).ready(function () {
            oTable = $('#levels').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.7/i18n/Spanish.json"
                },
                "ajax": "{{ route('admin.levels.data') }}",
                "columns": [
                    {data: "name"},
                    {data: "image"},
                    {data: "amount_needed"},
                    {data: "active"},
                    {data: "actions", "orderable": false, "searchable": false}
                ],
                "aLengthMenu": [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "{{ trans('general.all') }}"]
                ],
                // set the initial value
                "iDisplayLength": 10,
                "initComplete": function () {
                    // modify table search input
                    $('.dataTables_filter input').addClass("form-control input-sm").attr("placeholder", "{{ trans('general.search') }}");
                    // modify table per page dropdown
                    $('.dataTables_length select').addClass("m-wrap small");
                }
            });
        });
    </script>
@endsection