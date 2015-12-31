@extends('layouts.admin')

{{-- Styles --}}
@section('styles')
{{ HTML::style(Theme::asset('plugins/select2/select2.css')) }}
{{ HTML::style(Theme::asset('plugins/DataTables/media/css/DT_bootstrap.css')) }}
@endsection

{{-- Web site Title --}}
@section('title')
    {{{ $title }}} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
<h1>
    {{{ $title }}} <small>create and edit roles</small>
</h1>
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
<li>
    <i class="clip-bubbles-3"></i>
    <a href="{{ URL::route('admin.roles.index') }}">
        {{ trans('admin/site.roles') }}
    </a>
</li>
<li class="active">
    {{ trans('admin/role/title.roles_management') }}
</li>
@endsection

{{-- Content --}}
@section('content')

<!-- notifications -->
@include('notifications')
<!-- /.notifications -->

<!-- actions -->
<div class="row">
    <div class="col-md-12 space20">
        <a class="btn btn-green add-row" href="{{ URL::route('admin.roles.create') }}">
            <i class="fa fa-plus"></i> {{{ trans('admin/role/title.create_a_new_role') }}}
        </a>
    </div>
</div>
<!-- /.actions -->

<div class="row">
    <div class="col-xs-12">
             {{ $table
                    ->setClass('table table-striped table-bordered table-hover table-full-width')
                    ->render() }}
    </div>
</div>

@endsection

{{-- Scripts --}}
@section('scripts')
{{ $table
    ->setOptions(array(
        'sPaginationType' => 'bootstrap',
        'bProcessing' => true,
        'aoColumnDefs' => array('aTargets' => array(-1), 'bSortable' => false)
    ))
    ->script('partials.datatables') }}
@endsection