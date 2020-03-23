@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
    @lang('site.play') :: @parent
@endsection

{{-- Content Header --}}
@section('header')
    @lang('site.play')
@endsection

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('home') }}">
            <i class="fa fa-dashboard"></i> @lang('site.home')
        </a>
    </li>
    <li>
        <a href="{{ route('questions.index') }}">
            @lang('site.play')
        </a>
    </li>
    <li class="active">
        {{ $question->name }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    @include('partials.notifications')

    {!! Form::open(array('route' => ['questions.answer', $question->short_name])) !!}
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $question->name }}</h3>
        </div>
        <div class="box-body">
            {!! $question->question !!}

            <fieldset id="choicesGroup">
                <p>@lang('question/messages.choices')</p>
                @foreach($question->choices as $choice)
                    <div class="form-group">
                        @if($question->type == 'single')
                            <div class="radio icheck">
                                <label>{!! Form::radio('choices[]', $choice->id,  false) !!} {{ $choice->text }}</label>
                            </div>
                        @else
                            <div class="checkbox icheck">
                                <label>{!! Form::checkbox('choices[]', $choice->id,  false) !!} {{ $choice->text }}</label>
                            </div>
                        @endif
                    </div>
                @endforeach
            </fieldset>

        </div>
        <div class="box-footer">
            {!! Form::submit(__('question/messages.send'), ['class' => 'btn btn-primary', 'id' => 'btnSubmit']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/AdminLTE/plugins/iCheck/square/blue.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('vendor/AdminLTE/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });
        });
    </script>
@endpush
