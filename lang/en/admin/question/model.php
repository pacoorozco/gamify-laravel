<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * Some rights reserved. See LICENSE and AUTHORS files.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

use Gamify\Models\Question;

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
    'publication_date_placeholder' => 'Leave it empty to publish immediately.',
    'publish_immediately' => 'Publish immediately',
    'publish_on' => 'Publish on :datetime.',
    'published_on' => 'Published on :datetime.',
    'scheduled_for' => 'Scheduled for :datetime.',
    'published_not_yet' => 'Not published.',

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
    'choices_section' => 'Answers options',
    'choices_help' => 'These are the answers from which the participant can choose.',
    'choice_text' => 'Answer option text',
    'choice_text_help' => 'Put here the text of this answer option.',
    'choice_score' => 'Score',
    'choice_score_help' => 'Note that positive scores will mark answer as correct.',

    // Created / last saved
    'created_by' => 'Created by :who on :when.',
    'updated_by' => 'Updated by :who on :when.',

    'authored' => 'Authored',

];
