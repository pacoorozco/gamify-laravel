<?php

return [

    // General
    'short_name' => 'Short name',
    'permanent_link' => 'Permanent link',
    'name' => 'Question name',
    'name_help' => 'This is public, do not leak any information about the solution.',
    'question' => 'Question text',
    'question_help' => 'User\'s will see this text as the question to be answered.',
    'solution' => 'General feedback',
    'solution_help' => 'General feedback is shown to the user after they have completed the question. You can use to give users a fully worked answer and perhaps a link to more information.',
    'type' => 'Type',
    'type_list' => [
        'single' => 'Only one answer allowed',
        'multi' => 'Multiple answers allowed',
    ],
    'shuffle_choices' => 'Shuffle the choices?',
    'shuffle_choices_help' => 'If enabled, the order of the answers is randomly shuffled for each attempt.',

    'hidden' => 'Visibility',
    'hidden_help' => 'Hidden questions are only accessed via its URL.',
    'hidden_yes' => 'Hidden',
    'hidden_no' => 'Visible',

    'visibility_options' => [
        '0' => 'Public',
        '1' => 'Private',
    ],

    'status' => 'Status',
    'status_list' => [
        'draft' => 'Draft',
        'publish' => 'Published',
        'unpublish' => 'Retired',
    ],

    // Tags
    'tags' => 'Tags',
    'tags_help' => 'Enter tags separated by commas',
    'tags_none' => 'None',

    // Answers
    'choice_text' => 'Answer Text',
    'choice_text_help' => 'Put here the text of this choice',
    'choice_score' => 'Points',
    'choice_score_help' => 'Choices with positive points are considered as correct.',
    'choice_correct' => 'Is correct?',

    // Created / last saved
    'created_by' => 'Created by :who on :when',
    'updated_by' => 'Last saved by :who on :when',
    'published_at' => 'Published at',

];
