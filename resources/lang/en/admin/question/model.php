<?php

return [

    // General
    'short_name'           => 'Short name',
    'name'                 => 'Question name',
    'name_help'            => 'This is an internal name, users will never see this name.',
    'question'             => 'Question text',
    'question_help'        => 'This is the text user will see as a question.',
    'solution'             => 'General feedback',
    'solution_help'        => 'General feedback is shown to the user after they have completed the question. You can use to give users a fully worked answer and perhaps a link to more information.',
    'type'                 => 'One or multiple answers?',
    'type_list'            => [
        'single' => 'One answer only',
        'multi'  => 'Multiple answers allowed',
    ],
    'shuffle_choices'      => 'Shuffle the choices?',
    'shuffle_choices_help' => 'If enabled, the order of the answers is randomly shuffled for each attempt.',

    'hidden'      => 'Visible',
    'hidden_help' => 'Hidden questions can be only accessed via its URL.',
    'hidden_yes'  => 'Hide',
    'hidden_no'   => 'Show',

    'status'            => 'Status',
    'status_list'       => [
        'draft'     => 'Draft',
        'publish'   => 'Published',
        'unpublish' => 'Retired',
    ],

    // Tags
    'tags'              => 'Tags',
    'tags_help'         => 'Enter tags separated by commas',
    'tags_none'         => 'None',

    // Answers
    'choice_text'       => 'Answer Text',
    'choice_text_help'  => 'Put here the text of this choice',
    'choice_score'      => 'Points',
    'choice_score_help' => 'Choices with positive points are considered as correct.',
    'choice_correct'    => 'Is correct?',

    // Created / last saved
    'created_by'        => 'Created by :who on :when',
    'updated_by'        => 'Last saved by :who on :when',

];
