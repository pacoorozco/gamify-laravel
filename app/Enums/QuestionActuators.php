<?php

namespace Gamify\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OnQuestionAnswered()
 * @method static static OnQuestionCorrectlyAnswered()
 * @method static static OnQuestionIncorrectlyAnswered()
 */
final class QuestionActuators extends Enum
{
    /** Actuators based on question's events */
    const OnQuestionAnswered = 1;
    const OnQuestionCorrectlyAnswered = 2;
    const OnQuestionIncorrectlyAnswered = 3;
}
