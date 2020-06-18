<?php

use Gamify\Enums\BadgeActuators;

return [

    BadgeActuators::class => [
        BadgeActuators::OnQuestionAnswered => 'Question has been answered',
        BadgeActuators::OnQuestionCorrectlyAnswered => 'Question has been answered correctly',
        BadgeActuators::OnQuestionIncorrectlyAnswered => 'Question has been answered incorrectly',
        BadgeActuators::OnUserLogin => 'User has logged in',
    ],

];
