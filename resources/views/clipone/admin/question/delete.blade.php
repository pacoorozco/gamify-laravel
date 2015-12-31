@extends('layouts.admin')

{{-- Web site Title --}}
@section('title')
    {{ trans('admin/question/title.question_delete') }} :: @parent
@endsection

{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="page-header clearfix">
                <h3 class="pull-left">{{ trans('admin/question/title.question_delete') }}</h3>
                <div class="pull-right">
                    <a href="{{ route('admin.questions.index') }}" class="btn btn-sm btn-primary"><span
                                class="glyphicon glyphicon-arrow-left"></span> Back</a>
                </div>
            </div>

            <!-- Notifications -->
            @include('partials.notifications')
                    <!-- ./ notifications -->

            {{-- Delete Question Form --}}
            {!! Form::open(array('route' => array('admin.questions.destroy', $question->id), 'method' => 'delete', )) !!}

            @include('admin/question/_details')

            {!! Form::close() !!}
        </div>
    </div>
@endsection