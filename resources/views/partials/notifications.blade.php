{{-- Notifications --}}
@auth
    @foreach (Auth::user()->unreadNotifications as $notification)
        <x-alerts.notification :id="$notification->id"
                               :title="__('notifications.badge_unlocked_title')"
                               icon="'bi bi-award-fill'"
                               :when="$notification->created_at->diffForHumans()">
            {!! $notification->data['message'] !!}
        </x-alerts.notification>
    @endforeach
@endauth

{{-- Alerts --}}
@session('success')
<x-alerts.alert type="success">
    {{ $value }}
</x-alerts.alert>
@endsession

@session('warning')
<x-alerts.alert type="warning">
    {{ $value }}
</x-alerts.alert>
@endsession

@session('error')
<x-alerts.alert type="danger">
    {{ $value }}
</x-alerts.alert>
@endsession

@session('info')
<x-alerts.alert type="info">
    {{ $value }}
</x-alerts.alert>
@endsession

{{-- Validation Errors --}}
<x-alerts.validation-errors/>


