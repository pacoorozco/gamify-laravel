<?php

namespace Gamify\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\FlaggedEnum;
use Gamify\Presenters\BadgePresenter;

/**
 * @method static static OnQuestionAnswered()
 * @method static static OnQuestionCorrectlyAnswered()
 * @method static static OnQuestionIncorrectlyAnswered()
 * @method static static OnUserLogin()
 * @method static static None()
 */
final class BadgeActuators extends FlaggedEnum implements LocalizedEnum
{
    /** Actuators based on question's events */
    const OnQuestionAnswered = 1 << 0;
    const OnQuestionCorrectlyAnswered = 1 << 1;
    const OnQuestionIncorrectlyAnswered = 1 << 2;

    /** Actuators based on user's events */
    const OnUserLogin = 1 << 3;

    /**
     * Returns an array of values to be used on <select> with <optgroups> and filtered options.
     *
     * @return array
     * @see BadgePresenter::actuatorsSelect()
     */
    public static function toSelectArray(): array
    {
        return BadgePresenter::actuatorsSelect();
    }
}
