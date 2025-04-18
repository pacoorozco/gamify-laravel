@extends('layouts.admin')

{{-- Web site Title --}}
@section('title', __('admin/question/title.question_show'))

{{-- Content Header --}}
@section('header', __('admin/question/title.question_show'))

{{-- Breadcrumbs --}}
@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.home') }}">
            {{ __('admin/site.dashboard') }}
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.questions.index') }}">
            {{ __('admin/site.questions') }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        {{ __('admin/question/title.question_show') }}
    </li>
@endsection

{{-- Content --}}
@section('content')

    <!-- Notifications -->
    @include('partials.notifications')
    <!-- /.notifications -->

    <div class="row">

        <!-- left column -->
        <div class="col-md-8">

            <!-- general section -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        {{ $question->name }} {{ $question->present()->visibilityBadge() }} {{ $question->present()->statusBadge() }}
                    </h2>
                    <div class="card-tools">
                    <a href="{{ route('questions.show', ['q_hash' => $question->hash, 'slug' => $question->slug]) }}"
                       class="btn btn-tool float-right" target="_blank">
                        {{ __('general.view') }} <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                    </div>
                </div>
                <div class="card-body">
                    <h3>{{ __('admin/question/title.general_section') }}</h3>

                    <dl>

                        <!-- statement -->
                        <dt>{{ __('admin/question/model.question') }}</dt>
                        <dd id="question_statement">{{ $question->present()->statement() }}</dd>
                        <!-- ./ statement -->

                        @if($question->solution)
                            <!-- solution -->
                            <dt>{{ __('question/messages.explained_answer') }}</dt>
                            <dd id="question_explanation">{{ $question->present()->explanation() }}</dd>
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

                    </dl>
                </div>

                <div class="card-footer text-right">
                    <a href="{{ route('admin.questions.index') }}" class="btn btn-link" role="button">
                        {{ __('general.cancel') }}
                    </a>
                    <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-primary" role="button">
                        {{ __('general.edit') }}
                    </a>

                </div>

            </div>
            <!-- ./ general section -->

        </div>
        <!-- left column -->

        <!-- right column -->
        <div class="col-md-4">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('admin/question/title.badges_section') }}</h3>
                </div>
                    <div class="card-body">

                    <dl>
                        <!-- tags -->
                        <dt>{{ __('admin/question/model.tags') }}</dt>
                        <dd>
                            {{ $question->present()->tags() }}
                        </dd>
                        <!-- ./ tags -->
                    </dl>

                        <!-- badges -->
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>{{ __('admin/badge/model.name') }}</th>
                                    <th>{{ __('admin/badge/model.actuators') }}</th>
                                    <th>{{ __('admin/badge/model.tags') }}</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($relatedBadges as $badge)
                                    <tr>
                                        <td>{{ $badge->name }}</td>
                                        <td>{{ $badge->actuators->label() }}</td>
                                        <td>
                                            {{ $badge->present()->tagsIn($question->tagArrayNormalized) }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        <!-- ./ badges -->
                </div>
            </div>

            <!-- other information section -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('admin/question/title.other_section') }}</h3>
                    <div class="card-tools float-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="bi bi-dash"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    <dl class="dl-horizontal">

                        <!-- status -->
                        <dt>{{ __('admin/question/model.status') }}</dt>
                        <dd>
                            {{ $question->present()->statusBadge() }}
                        </dd>
                        <!-- ./ status -->

                        <!-- visibility -->
                        <dt>{{ __('admin/question/model.hidden') }}</dt>
                        <dd>{{ $question->present()->visibility() }}</dd>
                        <!-- ./ visibility -->

                        <!-- authored -->
                        <dt>{{ __('admin/question/model.authored') }}</dt>
                        <dd>
                            <ul class="list-unstyled">
                                <li>{{ __('admin/question/model.created_by', ['who' => $question->present()->creator(), 'when' => $question->created_at->toDayDateTimeString()]) }}</li>
                                <li>{{ __('admin/question/model.updated_by', ['who' => $question->present()->updater(), 'when' => $question->updated_at->toDayDateTimeString()]) }}</li>
                                <li>{{ $question->present()->publicationDateDescription() }}</li>
                            </ul>
                        </dd>
                        <!-- ./ authored -->

                    </dl>
                </div>
            </div>
            <!-- ./ other information section -->


            <!-- danger zone -->
            <div class="card">
                <div class="card-header bg-danger">
                    <strong>{{ __('admin/question/messages.danger_zone_section') }}</strong>
                </div>
                <div class="card-body">
                    <p><strong>{{ __('admin/question/messages.delete_button') }}</strong></p>
                    <p>{!! __('admin/question/messages.delete_help') !!}</p>

                    <div class="text-center">
                        <button type="button" class="btn btn-danger"
                                data-toggle="modal"
                                data-target="#confirmationModal">
                            {{ __('admin/question/messages.delete_button') }}
                        </button>
                    </div>
                </div>
            </div>
            <!-- ./danger zone -->

        </div>
    </div>

    <!-- confirmation modal -->
    <x-modals.confirmation
        :action="route('admin.questions.destroy', $question)"
        :confirmationText="$question->name"
        :buttonText="__('admin/question/messages.delete_confirmation_button')">

        <div class="alert alert-warning" role="alert">
            {!! __('admin/question/messages.delete_confirmation_warning', ['name' => $question->name]) !!}
        </div>
    </x-modals.confirmation>
    <!-- ./ confirmation modal -->
@endsection
