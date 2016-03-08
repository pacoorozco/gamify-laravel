<?php

namespace Gamify\Http\Controllers;

use Gamify\Point;
use Gamify\User;
use Illuminate\Support\Facades\Session;

class Game extends Controller
{
    /**
     * Add experience to an user.
     *
     * @param User $user
     * @param int $points
     * @param null $message
     * @return bool
     */
    public static function addExperience(User $user, $points = 5, $message = null)
    {
        if (empty($message)) {
            $message = trans('messages.unknown_reason');
        }

        // get the current user's level
        $level_before = $user->getLevelName();

        // add experience points to this user
        $point_entry = new Point([
            'points' => $points,
            'description' => $message,
        ]);
        $user->points()->save($point_entry);

        // get user's level after experience is added
        $level_after = $user->getLevelName();

        if ($level_after != $level_before) {
            // User has been level up!
            Session::flash('message_level', 'You have reached a new level');
        }

        return true;
    }

    public static function incrementBadge(User $user, Badge $badge)
    {
        $user->badges()->save($badge);

        Session::flash('message_badge', array('Bagde incremented'));
        return true;
    }
}
