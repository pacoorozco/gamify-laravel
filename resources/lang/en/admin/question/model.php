<?php

use Gamify\Question;

return [

    // General
    'short_name' => 'Short name',
    'permanent_link' => 'Permanent link',
    'name' => 'Question name',
    'name_help' => 'This is public, do not leak any information about the solution.',
    'question' => 'Statement of the question',
    'question_help' => 'User\'s will see this text as the statement of the question to be answered.',
    'solution' => 'Explanation',
    'solution_help' => 'Explanation is shown to the user after they have completed the question. You can use to give users a fully worked answer and perhaps a link to more information.',
    'type' => 'Type',
    'type_list' => [
        Question::SINGLE_RESPONSE_TYPE => 'Single choice question',
        Question::MULTI_RESPONSE_TYPE => 'Multiple choice question',
    ],
    'shuffle_choices' => 'Shuffle the choices?',
    'shuffle_choices_help' => 'If enabled, the order of the answers is randomly shuffled for each attempt.',

    'publication_date' => 'Publication date',
    'publication_date_placeholder' => 'Leave it empty to publish immediately',
    'publish_immediately' => 'Publish immediately',
    'publish_on' => 'Publish on :datetime',
    'published_on' => 'Published on :datetime',
    'scheduled_for' => 'Scheduled for :datetime',

    'hidden' => 'Visibility',
    'hidden_yes' => 'Private',
    'hidden_yes_help' => 'Private questions are not published on the dashboards. They are only accessed via its URL.',
    'hidden_no' => 'Public',
    'hidden_no_help' => 'Public questions are listed on the user\'s dashboard.',

    'status' => 'Status',
    'status_list' => [
        Question::DRAFT_STATUS => 'Draft',
        Question::PUBLISH_STATUS => 'Published',
        Question::FUTURE_STATUS => 'Scheduled',
    ],

    // Tags
    'tags' => 'Tags',
    'tags_help' => 'Enter tags separated by commas',
    'tags_none' => 'None',

    // Answers
    'choices_section' => 'Answer options',
    'choices_help' => 'These are the options from which the participant can choose. Note that <strong>positive scores will mark option as correct</strong>.',
    'choice_text' => 'Option Text',
    'choice_text_help' => 'Put here the text of this answer option.',
    'choice_score' => 'Score',
    'choice_score_help' => 'Choices with positive points are considered as correct.',
    'choice_correctness' => 'Correctness',

    // Created / last saved
    'created_by' => 'Created by :who on :when',
    'updated_by' => 'Last saved by :who on :when',

];
