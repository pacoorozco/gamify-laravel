<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading-{{ $question->short_name }}">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion"
               href="#collapse-{{ $question->short_name }}" aria-expanded="false"
               aria-controls="collapse-{{ $question->short_name }}">
                {{ $question->name }}
            </a>
        </h4>
    </div>
    <div id="collapse-{{ $question->short_name }}" class="panel-collapse collapse"
         role="tabpanel" aria-labelledby="heading-{{ $question->short_name }}">
        <div class="panel-body">
            {!! $question->excerpt() !!}

            <a href="{{ route('questions.show', $question->short_name) }}"
               class="btn btn-primary pull-right">More...</a>
        </div>
    </div>
</div>
