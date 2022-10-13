<?php

namespace Gamify\Observers;

use Gamify\Models\Level;
use Illuminate\Support\Facades\Cache;

class LevelObserver
{
    public function created(Level $level): void
    {
        Cache::forget('levels');
    }

    public function updated(Level $level): void
    {
        Cache::forget('levels');
    }

    public function deleted(Level $level): void
    {
        Cache::forget('levels');
    }

    public function restored(Level $level): void
    {
        Cache::forget('levels');
    }

    public function forceDeleted(Level $level): void
    {
        //
    }
}
