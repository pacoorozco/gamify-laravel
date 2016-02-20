
<!-- start: Badge Gallery -->
<div class="row">
    <div class="col-sm-12"></div>
</div>

<div class="row">
    @foreach ($user->badges as $badge)

    <div class="col-md-3 col-sm-4 gallery-img">
        <div class="wrap-image">
            <img src="{{ $badge->image->url('medium') }}" alt="{{{ $badge->name }}}" width="128" class="img-responsive center-block">
            <div class="tools tools-bottom">
                <p>{{{ $badge->name }}} {{{ $badge->pivot->completed_on }}} </p>
            </div>
        </div>
    </div>

    @endforeach
</div>