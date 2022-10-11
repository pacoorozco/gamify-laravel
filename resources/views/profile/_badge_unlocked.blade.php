<div class="col-xs-2">
    <a href="#badge-{{ $badge->slug() }}" data-toggle="modal">
        {{ $badge->present()->imageThumbnail() }}
    </a>
</div>

<!-- Modal -->
<div class="modal fade" id="badge-{{ $badge->slug() }}" tabindex="-1" role="dialog"
     aria-labelledby="badge-{{ $badge->slug() }}Label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="{{ __('general.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="badge-{{ $badge->slug() }}Label">
                    {{ __('user/profile.badge') }}: {{ $badge->name }}
                </h4>
            </div>
            <div class="modal-body text-center">
                <p class="lead">
                    {{ __('user/profile.congrats_message', ['name' => $badge->name]) }}
                </p>

                <p>{{ $badge->present()->imageThumbnail() }}</p>

                <p>
                    {{ $badge->description }}
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">{{ __('general.close') }}</button>
            </div>
        </div>
    </div>
</div>
