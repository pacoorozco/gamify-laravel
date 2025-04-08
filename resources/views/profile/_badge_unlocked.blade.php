<div class="col">
    <a href="#badge-{{ $badge->slug() }}" data-toggle="modal">
        {{ $badge->present()->imageThumbnail() }}
    </a>


    <!-- Modal -->
    <div class="modal fade" id="badge-{{ $badge->slug() }}" tabindex="-1"
         aria-labelledby="badge-{{ $badge->slug() }}Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="badge-{{ $badge->slug() }}Label">
                        {{ __('user/profile.badge') }}: {{ $badge->name }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('general.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <p>
                        {{ __('user/profile.congrats_message', ['name' => $badge->name]) }}
                    </p>

                    <p>{{ $badge->present()->imageThumbnail() }}</p>

                    <p>
                        {{ $badge->description }}
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">{{ __('general.close') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
