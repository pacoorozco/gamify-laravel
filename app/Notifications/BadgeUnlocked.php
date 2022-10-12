<?php

namespace Gamify\Notifications;

use Gamify\Models\Badge;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BadgeUnlocked extends Notification
{
    use Queueable;

    public function __construct(
        private Badge $badge,
    ) {
        //
    }

    public function via(mixed $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(mixed $notifiable): array
    {
        return $this->toArray($notifiable);
    }

    public function toArray(mixed $notifiable): array
    {
        return [
            'title' => __('notifications.badge_unlocked_title'),
            'message' => __('notifications.badge_unlocked_message', ['name' => $this->badge->name, 'url' => route('account.index')]),
        ];
    }
}
