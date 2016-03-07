<?php

namespace Gamify\Http\Controllers;

use Gamify\Point;
use Gamify\User;
use Illuminate\Support\Facades\Session;

class Game extends Controller
{
    public static function giveXP(User $user, $points, $message)
    {
        // get original User's level
        $level_before = $user->getLevel();

        // add experience to the user
        $point_entry = new Point([
            'points' => $points,
            'description' => $message,
        ]);

        $user->points()->save($point_entry);

        // get final User's level
        $level_after = $user->getLevel();

        if ($level_after != $level_before) {
            Session::flash('message_level', 'You have reached a new level');
        }

        return true;
    }

    public static function incrementBadges(User $user, $badges)
    {
        Session::flash('message_badge', array('Bagde incremented'));
        return true;
    }
}
