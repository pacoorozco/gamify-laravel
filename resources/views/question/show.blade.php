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
                <h4>@lang('question/messages.choices')</h4>
                @foreach($question->choices as $choice)
                    <div class="form-group">
                        @if($question->type == 'single')
                            <div class="radio">
                                <label>{!! Form::radio('choices[]', $choice->id,  false) !!} {{ $choice->text }}</label>
                            </div>
                        @else
                            <div class="checkbox">
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

{{-- Scripts --}}
@push('scripts')
    <script>
        $(function () {
            $("#btnSubmit").click(function () {
                let checked = $("#choicesGroup input[type=checkbox]:checked").length;
                let isValid = checked > 0;

                let errorMessage = isValid ? '' : 'At least one checkbox must be selected.';
                $('input:checkbox:first').setCustomValidity(errorMessage);
            });
        });
    </script>
@endpush
