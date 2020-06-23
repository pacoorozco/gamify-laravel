<?php

namespace Gamify\Libs\Game;

use Gamify\Badge;
use Gamify\Level;
use Gamify\Point;
use Gamify\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;

class Game
{
    /**
     * Add experience to an user.
     *
     * @param User   $user
     * @param int    $points
     * @param string $message
     *
     * @return bool
     */
    public static function addReputation(User $user, $points = 5, $message = '')
    {
        // add experience points to this user
        $point_entry = new Point([
            'points' => $points,
            'description' => (! empty($message)) ?: __('messages.unknown_reason'),
        ]);

        return ($user->points()->save($point_entry) === false) ?: true;
    }

    /**
     * Add more repetitions towards a collection of Badges.
     *
     * @param \Gamify\User                             $user
     * @param \Illuminate\Database\Eloquent\Collection $badges
     */
    public static function incrementManyBadges(User $user, Collection $badges): void
    {
        foreach ($badges as $badge) {
            self::incrementBadge($user, $badge);
        }
    }

    /**
     * Give one more action towards a Badge for an User.
     *
     * @param User  $user
     * @param Badge $badge
     *
     * @return void
     */
    public static function incrementBadge(User $user, Badge $badge): void
    {
        if ($user->hasBadgeCompleted($badge)) {
            return;
        }

        try {
            $userBadge = $user->badges()->wherePivot('badge_id', $badge->id)->firstOrFail();
            // this badge was initiated before
            $data['repetitions'] = $userBadge->pivot->repetitions + 1;
            $user->badges()->updateExistingPivot($badge->id, $data);
        } catch (ModelNotFoundException $exception) {
            // this is the first occurrence of this badge for this user
            $data['repetitions'] = 1;
            $user->badges()->attach($badge->id, $data);
        }

        if ($data['repetitions'] === $badge->required_repetitions) {
            self::giveCompletedBadge($user, $badge);
        }
    }

    /**
     * Give a completed Badge for an User.
     *
     * @param User  $user
     * @param Badge $badge
     *
     * @return void
     */
    public static function giveCompletedBadge(User $user, Badge $badge): void
    {
        if ($user->hasBadgeCompleted($badge)) {
            return;
        }

        $data = [
            'repetitions' => $badge->required_repetitions,
            'completed' => true,
            'completed_on' => now(),
        ];

        try {
            $user->badges()->wherePivot('badge_id', $badge->id)->firstOrFail();
            // this badge was initiated before
            $user->badges()->updateExistingPivot($badge->id, $data);
        } catch (ModelNotFoundException $exception) {
            // this is the first occurrence of this badge for this user
            $user->badges()->attach($badge->id, $data);
        }
    }

    /**
     * Get a collection with members ordered by Experience Points.
     *
     * @param int $limitTopUsers
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getRanking($limitTopUsers = 10)
    {
        $users = User::Member()
            ->select([
                'name',
                'username',
                'experience',
            ])
            ->orderBy('experience', 'DESC')
            ->take($limitTopUsers)
            ->get();

        $rank = $users->map(function ($user) {
            $experience = $user->getExperiencePoints();

            return [
                'username' => $user->username,
                'name' => $user->name,
                'experience' => $experience,
                'level' => (empty(Level::findByExperience($experience))) ? 'Null' : Level::findByExperience($experience)->name,
            ];
        });

        return $rank;
    }
}
