@extends('layouts.admin')

{{-- Styles --}}
@section('styles')
{{ HTML::style(Theme::asset('plugins/select2/select2.css')) }}
{{ HTML::style(Theme::asset('plugins/DataTables/media/css/DT_bootstrap.css')) }}
@stop

{{-- Web site Title --}}
@section('title')
    {{{ $title }}} :: @parent
@stop

{{-- Content Header --}}
@section('header')
<h1>
    {{{ $title }}} <small>create and edit levels</small>
</h1>
@stop

{{-- Breadcrumbs --}}
@section('breadcrumbs')
<li>
    <i class="clip-bubbles-3"></i>
    <a href="{{ URL::route('admin.levels.index') }}">
        {{ trans('admin/site.levels') }}
    </a>
</li>
<li class="active">
    {{ trans('admin/badge/title.level_management') }}
</li>
@stop


{{-- Content --}}
@section('content')

<!-- Notifications -->
@include('notifications')
<!-- ./ notifications -->

<!-- actions -->
<div class="row">
    <div class="col-md-12 space20">
        <a class="btn btn-green add-row" href="{{ URL::route('admin.levels.create') }}">
            <i class="fa fa-plus"></i> {{{ trans('admin/level/title.create_a_new_level') }}}
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

@stop

{{-- Scripts --}}
@section('scripts')
{{ $table
    ->setOptions(array(
        'sPaginationType' => 'bootstrap',
        'bProcessing' => true,
        'aoColumnDefs' => array('aTargets' => array(1, -1), 'bSortable' => false)
    ))
    ->script('partials.datatables') }}
@stop