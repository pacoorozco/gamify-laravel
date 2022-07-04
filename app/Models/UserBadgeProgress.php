<?php

namespace Gamify\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

/**
 * User's progress towards a badge.
 *
 * @property-read int $repetitions
 * @property-read Carbon $unlocked_at
 */
class UserBadgeProgress extends Pivot
{
    protected $casts = [
        'unlocked_at' => 'datetime',
    ];
}
