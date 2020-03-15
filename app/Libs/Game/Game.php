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
     * @return bool
     */
    public static function incrementBadge(User $user, Badge $badge): bool
    {
        try {
            $userBadge = $user->badges()->findOrFail($badge->id);
        } catch (ModelNotFoundException $exception) {
            // this is the first occurrence of this badge for this user
            $user->badges()->attach($badge->id, ['repetitions' => '1']);

            return true;
        }

        if ($user->hasBadgeCompleted($badge)) {
            return true;
        }

        // this badge was initiated before
        $userBadge->pivot->repetitions++;
        if ($userBadge->pivot->repetitions === $badge->required_repetitions) {
            $userBadge->pivot->completed = true;
            $userBadge->pivot->completed_on = Carbon::now();
        }

        return ($userBadge->pivot->save() === false) ?: true;
    }

    /**
     * Give a completed Badge for an User.
     *
     * @param User  $user
     * @param Badge $badge
     *
     * @return bool
     */
    public static function addBadge(User $user, Badge $badge): bool
    {
        if ($user->hasBadgeCompleted($badge)) {
            return true;
        }

        $data = [
            'repetitions' => $badge->required_repetitions,
            'completed' => true,
            'completed_on' => Carbon::now(),
        ];

        try {
            $userBadge = $user->badges()->findOrFail($badge->id);
            // this badge was initiated before
            return ($userBadge->pivot->save($data) === false) ?: true;
        } catch (ModelNotFoundException $exception) {
            // this is the first occurrence of this badge for this user
            $user->badges()->attach($badge->id, $data);

            return true;
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
