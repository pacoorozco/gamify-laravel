<?php

namespace Gamify\Http\Controllers;

use Gamify\Point;
use Gamify\User;
use Gamify\Badge;
use Illuminate\Support\Facades\Session;

class Game extends Controller
{
    /**
     * Add experience to an user
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
            Session::flash('messages', 'You have reached a new level');
        }

        return true;
    }

    /**
     * Give one more action towards a Badge for an User
     *
     * @param User $user
     * @param Badge $badge
     * @return bool
     */
    public static function incrementBadge(User $user, Badge $badge)
    {
        $user->badges()->save($badge);

        Session::flash('messages', array('Badge incremented'));
        return true;
    }

    public static function getRanking($limitTopUsers = 10)
    {
        $ranking = User::Member()->with('points')->get();

        $prova = [];
        $i=0;
        foreach($ranking as $user) {
            $prova[$i]['user'] = $user->name;
            $prova[$i]['points'] = $user->getExperiencePoints();
            $i++;
        }

        dd($prova);
    }
}
