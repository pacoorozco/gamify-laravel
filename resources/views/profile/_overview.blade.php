<p>{{ $user->profile->bio or 'Nothing' }}</p>

Badges


@foreach($user->badges as $badge)
    <img class=img-responsive" src="{{ $badge->image->url() }}"
             alt="">
    @endforeach


