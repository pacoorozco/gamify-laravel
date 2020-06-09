<?php

namespace Gamify\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\FlaggedEnum;

/**
 * @method static static OnQuestionAnswered()
 * @method static static OnQuestionCorrectlyAnswered()
 * @method static static OnQuestionIncorrectlyAnswered()
 * @method static static OnUserLogin()
 * @method static static None()
 */
final class BadgeActuators extends FlaggedEnum implements LocalizedEnum
{
    const OnQuestionAnswered = 1 << 0;
    const OnQuestionCorrectlyAnswered = 1 << 1;
    const OnQuestionIncorrectlyAnswered = 1 << 2;
    const OnUserLogin = 1 << 3;
}
