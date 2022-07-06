<div class="box box-success">
    <div class="box-header with-border">
        <i class="fa fa-question"></i>
        <h3 class="box-title">Latest published questions</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-sm" data-widget="collapse">
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
                <th>{{ __('admin/question/model.type') }}</th>
                <th>{{ __('admin/question/model.hidden') }}</th>
                <th>{{ __('admin/question/model.publication_date') }}</th>
                <th>{{ __('general.edit') }}</th>
            </tr>
            </thead>
            @foreach($latest_questions as $question)
                <tr>
                    <td>
                        {{ $question->present()->name }}
                        {{ $question->present()->publicUrlLink }}
                    </td>
                    <td>
                        {{ $question->present()->typeIcon }}
                    </td>
                    <td>
                        @if($question->hidden)
                            <span class="badge">{{ __('admin/question/model.hidden_yes') }}</span>
                        @endif
                    </td>
                    <td>{{ $question->publication_date }}</td>
                    <td><a href="{{ route('admin.questions.edit', $question) }}"><i class="fa fa-edit"></a></td>
                </tr>
            @endforeach
        </table>
    </div>
    <!-- /.box-body -->
</div>
