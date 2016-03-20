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

        // add experience points to this user
        $point_entry = new Point([
            'points' => $points,
            'description' => $message,
        ]);

        return is_null($user->points()->save($point_entry)) ? false : true;
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
        return is_null($user->badges()->save($badge)) ? false : true;
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
