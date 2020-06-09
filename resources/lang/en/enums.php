<?php

use Gamify\Enums\BadgeActuators;

return [

    BadgeActuators::class => [
        BadgeActuators::OnQuestionAnswered => 'When a question is answered',
        BadgeActuators::OnQuestionCorrectlyAnswered => 'When a question is answered correctly',
        BadgeActuators::OnQuestionIncorrectlyAnswered => 'When a question is answered incorrectly',
        BadgeActuators::OnUserLogin => 'When user logs in',
    ],

];
