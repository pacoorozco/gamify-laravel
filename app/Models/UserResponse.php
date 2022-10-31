<?php

namespace Gamify\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * It's the response to a question.
 *
 * @property-read int $points
 * @property-read string $answers
 */
class UserResponse extends Pivot
{
    const VALUE_SEPARATOR = ',';

    public static function asArray(int $score, array $choices): array
    {
        return [
            // We always get 1 XP for each user's response, even if it was the wrong one.
            'points' => ($score > 0) ? $score : 1,
            'answers' => implode(self::VALUE_SEPARATOR, $choices),
        ];
    }

    public function score(): int
    {
        return $this->points;
    }

    public function hasChoice(int $choice): bool
    {
        return in_array($choice, $this->choices());
    }

    public function choices(): array
    {
        return explode(self::VALUE_SEPARATOR, $this->answers);
    }
}
