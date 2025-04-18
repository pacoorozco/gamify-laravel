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
    'name' => 'Question title',
    'name_help' => 'A brief, descriptive title that identifies this question in listings. This will be visible to players and used to generate the question\'s URL.',
    'question' => 'Question content',
    'question_help' => 'The full text of your question including any necessary context or scenario. This is what players will read before answering.',
    'solution' => 'Solution explanation',
    'solution_help' => 'Additional information revealed after answering that explains the correct solution and provides educational context. Use this to help players learn from both correct and incorrect answers.',
    'type' => 'Answer format',
    'type_help' => 'Choose how players can respond to this question.',
    'type_list' => [
        Question::SINGLE_RESPONSE_TYPE => 'Single choice',
        Question::MULTI_RESPONSE_TYPE => 'Multiple choice',
    ],
    'shuffle_choices' => 'Shuffle the choices?',
    'shuffle_choices_help' => 'If enabled, the order of the answers is randomly shuffled for each attempt.',

    'publication_date' => 'Publication date',
    'publication_date_placeholder' => 'Not scheduled (publishes immediately)',
    'publication_date_help' => 'Choose when to publish this question. Leave empty to publish immediately.',
    'publish_immediately' => 'Not scheduled (publishes immediately)',
    'publish_on' => 'Publish on :datetime.',
    'published_on' => 'Published on :datetime.',
    'scheduled_for' => 'Scheduled for :datetime.',
    'published_not_yet' => 'Not published.',
    'publish' => 'Publish',

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
    'tags_help' => 'Add relevant keywords to categorize this question. Tags help organize questions and can be used to award specialized badges when players master specific topics.',
    'tags_placeholder' => 'Enter tags separated by commas.',
    'tags_none' => 'None',

    // Answers
    'choices_section' => 'Answers options',
    'choices_help' => 'Define the possible answers players can select.',
    'choice_text' => 'Option text',
    'choice_text_help' => 'The answer choice text shown to players.',
    'choice_score' => 'Points',
    'choice_score_help' => 'Use positive values for correct answers and negative values for incorrect ones.',

    // Created / last saved
    'created_by' => 'Created by :who on :when.',
    'updated_by' => 'Updated by :who on :when.',

    'authored' => 'Authored',

];
