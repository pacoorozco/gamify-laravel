@auth
    @foreach (Auth::user()->unreadNotifications as $notification)
        <div class="alert alert-success alert-dismissible" role="alert">
            <strong>
                {{ __('notifications.badge_unlocked_title') }}
                <small class="pull-right time">
                    <i class="bi bi-clock-fill-o"></i>
                    {{ $notification->created_at->diffForHumans() }}
                </small>
            </strong>
            <p>
                {!! $notification->data['message'] !!}
                <a href="#" class="pull-right mark-as-read" data-id="{{ $notification->id }}" data-dismiss="alert">
                    {{ __('notifications.mark_as_read') }}
                </a>
            </p>
        </div>
    @endforeach

    @pushonce('scripts')
        <script>
            function sendMarkRequest(id = null) {
                return $.ajax({
                    url: "{{ route('notifications.read') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PATCH',
                        id: id
                    }
                });
            }

            $(function () {
                $('.mark-as-read').click(function () {
                    sendMarkRequest($(this).data('id'));
                });
            });
        </script>
    @endpushonce
@endauth

@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fa fa-check"></i> {{ __('general.success') }}</h5>
        {{ session()->get('success') }}
    </div>
@endif

@if (session()->has('warning'))
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fa fa-warning"></i> {{ __('general.warning') }}</h5>
        {{ session()->get('warning') }}
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fa fa-ban"></i> {{ __('general.error') }}</h5>
        {{ session()->get('error') }}
    </div>
@endif

@if (session()->has('info'))
    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fa fa-info"></i> Info</h5>
        {{ session()->get('info') }}
    </div>
@endif

@if (session()->has('message'))
    <div class="callout callout-info">
        {{ session()->get('message') }}
    </div>
@endif

@if ($errors->any())
    <div class="callout callout-danger">
        <h5>{{ __('general.validation_error') }}</h5>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


