<p>{{ $user->profile->bio }}</p>

<h3>{{ trans('user/profile.badges') }}</h3>

<div class="row">
    @foreach($user->badges as $badge)
        <div class="col-xs-2">
            <a href="#badge-{{ $badge->name }}" class="thumbnail" data-toggle="modal">
                @if ($badge->pivot->completed)
                    <img src="{{ $badge->image->url() }}" alt="{{ $badge->name }}">
                @else
                    <img src="{{ asset('images/missing_badge.png') }}" alt="{{ $badge->name }}">
                @endif
            </a>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="badge-{{ $badge->name }}" tabindex="-1" role="dialog"
             aria-labelledby="badge-{{ $badge->name }}Label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="{{ trans('general.close') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="badge-{{ $badge->name }}Label">
                            {{ trans('user/profile.badge') }}: {{ $badge->name }}
                            @if ($badge->pivot->completed)
                                <span class="label label-success">{{ trans('user/profile.badge_completed') }}</span>
                            @endif
                        </h4>
                    </div>
                    <div class="modal-body text-center">
                        @if ($badge->pivot->completed)
                            <img src="{{ $badge->image->url() }}" alt="{{ $badge->name }}">
                            <p>{{ $badge->description }}</p>
                        @else
                            <img src="{{ asset('images/missing_badge.png') }}" alt="{{ $badge->name }}">
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">{{ trans('general.close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>




