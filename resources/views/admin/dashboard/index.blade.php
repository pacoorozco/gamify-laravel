@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ trans('admin/site.dashboard') }} :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    {{ trans('admin/site.dashboard') }}
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li class="active">
        <i class="fa fa-dashboard"></i> {{ trans('admin/site.dashboard') }}
    </li>
@endsection

@section('content')
        <!-- Info boxes -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-trophy"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Badges</span>
                    <span class="info-box-number">{{ $data['badges'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-comments"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Questions</span>
                    <span class="info-box-number">{{ $data['questions'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-bank"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Answers</span>
                    <span class="info-box-number">{{ $data['answers'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Members</span>
                    <span class="info-box-number">{{ $data['members'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection
