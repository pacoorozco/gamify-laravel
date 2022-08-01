@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/question/title.question_show'))

{{-- Content Header --}}
@section('header', __('admin/question/title.question_show'))

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li>
        <a href="{{ route('admin.home') }}">
            <i class="fa fa-dashboard"></i> {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li>
        <a href="{{ route('admin.questions.index') }}">
            {{ __('admin/site.questions') }}
        </a>
    </li>
    <li class="active">
        {{ __('admin/question/title.question_show') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- /.notifications -->

    <div class="box box-solid">
        <div class="box-header with-border">
            <h2 class="box-title">
                {{ $question->present()->name }}
            </h2>
            {{ $question->present()->visibilityBadge }}
            {{ $question->present()->statusBadge }}

            <a href="{{ $question->present()->public_url }}"
               class="btn btn-link pull-right" target="_blank">
                {{ __('general.view') }} <i class="fa fa-external-link"></i>
            </a>
        </div>
        <div class="box-body">
            <div class="row">

                <!-- left column -->
                <div class="col-xs-6">

                    <dl>

                        <!-- statement -->
                        <dt>{{ __('admin/question/model.question') }}</dt>
                        <dd>{{ $question->present()->statement }}</dd>
                        <!-- ./ statement -->

                        @if($question->solution)
                        <!-- solution -->
                        <dt>{{ __('question/messages.explained_answer') }}</dt>
                        <dd>{{ $question->present()->explanation }}</dd>
                        <!-- ./ solution -->
                        @endif

                        <!-- choices -->
                        <dt>
                            @if($question->type == 'single')
                                {{ __('question/messages.single_choice') }}
                            @else
                                {{ __('question/messages.multiple_choices') }}
                            @endif
                        </dt>
                        <dd>
                            <ul class="list-group">
                                @forelse($question->choices as $choice)
                                    <li class="list-group-item">
                                        @if($choice->isCorrect())
                                            <span class="glyphicon glyphicon-ok"></span>
                                            <span
                                                class="label label-success pull-right">{{ __('question/messages.choice_score', ['points' => $choice->score]) }}</span>
                                        @else
                                            <span class="glyphicon glyphicon-remove"></span>
                                            <span
                                                class="label label-danger pull-right">{{ __('question/messages.choice_score', ['points' => $choice->score]) }}</span>
                                        @endif

                                        {{ $choice->text }}
                                    </li>
                                @empty
                                    <li class="list-group-item text-center">{{ __('admin/question/messages.choices_unavailable') }}</li>
                                @endforelse

                                <li class="list-group-item bg-gray text-center">
                                    <p class="text-muted">
                                        {{ __('question/messages.legend') }}
                                        <span
                                            class="glyphicon glyphicon-ok"></span> {{ __('question/messages.correct_answer') }}
                                        <span
                                            class="glyphicon glyphicon-remove"></span> {{ __('question/messages.incorrect_answer') }}
                                    </p>
                                </li>
                            </ul>
                        </dd>
                        <!-- ./ choices -->

                        <!-- badges -->
                        <dt>{{ __('admin/question/title.badges_section') }}</dt>
                        <dd>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th>{{ __('admin/action/table.action') }}</th>
                                    <th>{{ __('admin/action/table.when') }}</th>
                                </tr>

                                @foreach($globalActions as $badge)
                                    <tr>
                                        <td>{{ $badge->name }}</td>
                                        <td>{{ $badge->actuators->description }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </dd>
                        <!-- ./ badges -->

                    </dl>

            </div>
            <!-- ./ left column -->

            <!-- right column -->
            <div class="col-xs-6">

                <dl class="dl-horizontal">

                    <!-- status -->
                    <dt>{{ __('admin/question/model.status') }}</dt>
                    <dd>
                        {{ $question->present()->statusBadge }}
                    </dd>
                    <!-- ./ status -->

                    <!-- visibility -->
                    <dt>{{ __('admin/question/model.hidden') }}</dt>
                    <dd>{{ $question->present()->visibility }}</dd>
                    <!-- ./ visibility -->

                    <!-- authored -->
                    <dt>{{ __('admin/question/model.authored') }}</dt>
                    <dd>
                        <ul class="list-unstyled">
                            <li>{{ __('admin/question/model.created_by', ['who' => $question->creator->username, 'when' => $question->created_at]) }}</li>
                            <li>{{ __('admin/question/model.updated_by', ['who' => $question->updater->username, 'when' => $question->updated_at]) }}</li>
                            <li>{{ $question->present()->publicationDateDescription }}</li>
                        </ul>
                    </dd>
                    <!-- ./ authored -->

                </dl>


                <!-- danger zone -->
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <strong>@lang('admin/question/messages.danger_zone_section')</strong>
                    </div>
                    <div class="panel-body">
                        <p><strong>@lang('admin/question/messages.delete_button')</strong></p>
                        <p>@lang('admin/question/messages.delete_help')</p>

                        <div class="text-center">
                            <button type="button" class="btn btn-danger"
                                    data-toggle="modal"
                                    data-target="#confirmationModal">
                                @lang('admin/question/messages.delete_button')
                            </button>
                        </div>
                    </div>
                </div>
                <!-- ./danger zone -->

            </div>
            <!-- ./ right column -->

        </div>
    </div>

    <div class="box-footer">
        <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-primary" role="button">
            {{ __('general.edit') }}
        </a>
        <a href="{{ route('admin.questions.index') }}" class="btn btn-link" role="button">
            {{ __('general.back') }}
        </a>
    </div>
    </div>

    <!-- confirmation modal -->
    <x-modals.confirmation
        action="{{ route('admin.questions.destroy', $question) }}"
        confirmationText="{{ $question->name }}"
        buttonText="{{ __('admin/question/messages.delete_confirmation_button') }}">

        <div class="alert alert-warning" role="alert">
            @lang('admin/question/messages.delete_confirmation_warning', ['name' => $question->name])
        </div>
    </x-modals.confirmation>
    <!-- ./ confirmation modal -->
@endsection
