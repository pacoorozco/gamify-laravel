<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading-{{ $question->hash }}">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion"
               href="#collapse-{{ $question->hash }}" aria-expanded="false"
               aria-controls="collapse-{{ $question->hash }}">
                {{ $question->name }}
            </a>
        </h4>
    </div>
    <div id="collapse-{{ $question->hash }}" class="panel-collapse collapse"
         role="tabpanel" aria-labelledby="heading-{{ $question->hash }}">
        <div class="panel-body">
            {!! $question->excerpt() !!}

            <a href="{{ route('questions.show', ['q_hash' => $question->hash, 'slug' => $question->slug]) }}"
               class="btn btn-primary pull-right">More...</a>
        </div>
    </div>
</div>
