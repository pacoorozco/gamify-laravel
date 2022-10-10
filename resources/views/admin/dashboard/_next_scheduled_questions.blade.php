<div class="box">
    <div class="box-header">
        <i class="fa fa-clock-o"></i>
        <h3 class="box-title">Next scheduled questions</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>{{ __('admin/question/model.name') }}</th>
                <th>{{ __('admin/question/model.hidden') }}</th>
                <th>{{ __('admin/question/model.publication_date') }}</th>
                <th>{{ __('general.edit') }}</th>
            </tr>
            </thead>
            @forelse($next_scheduled_questions as $question)
                <tr>
                    <td>
                        {{ $question->present()->name }}
                        {{ $question->present()->publicUrlLink }}
                    </td>
                    <td>
                        {{ $question->present()->visibilityBadge() }}
                    </td>
                    <td>{{ $question->present()->publication_date }}</td>
                    <td>
                        <a href="{{ route('admin.questions.edit', $question) }}">
                            <button type="button" class="btn btn-xs btn-primary" title="{{ __('general.edit') }}">
                                <i class="fa fa-edit"></i>
                            </button>
                        </a>
                    </td>
                </tr>
            @empty
                <tr class="warning">
                    <td colspan="5" class="text-center">{{ __('admin/question/messages.no_scheduled_questions') }}</td>
                </tr>
            @endforelse
        </table>
    </div>
    <!-- /.box-body -->
</div>
