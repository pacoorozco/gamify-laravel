<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading-{{ $question->shortname }}">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion"
               href="#collapse-{{ $question->shortname }}" aria-expanded="false"
               aria-controls="collapse-{{ $question->shortname }}">
                {{ $question->name }}
            </a>
        </h4>
    </div>
    <div id="collapse-{{ $question->shortname }}" class="panel-collapse collapse"
         role="tabpanel" aria-labelledby="heading-{{ $question->shortname }}">
        <div class="panel-body">
            {!! $question->excerpt() !!}

            <a href="{{ route('questions.show', $question->shortname) }}"
               class="btn btn-primary pull-right">More...</a>
        </div>
    </div>
</div>