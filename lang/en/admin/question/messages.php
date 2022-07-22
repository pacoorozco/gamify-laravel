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

return [
    'publish' => [
        'error' => 'This question can\'t be published. You must give two or more answer choices and at least one of them must be correct.',
    ],

    'create' => [
        'error' => 'Question was not created, please try again.',
        'success' => 'Question created successfully.',
    ],

    'update' => [
        'error' => 'Question was not updated, please try again',
        'success' => 'Question updated successfully.',
    ],

    'delete' => [
        'error' => 'There was an issue deleting the question. Please try again.',
        'success' => 'The question was deleted successfully.',
    ],

    'un-publish_confirmation_button' => 'Yes, un-publish the question',
    'un-publish_confirmation_notice' => 'This question is published, if you proceed it will be un-published. It means that nobody will be able to access to it until you publish it again.',

    'choices_unavailable' => 'There aren\'t choices yet. Consider adding at least two before publishing it.',

    'danger_zone_section' => 'Danger Zone',
    'delete_button' => 'Delete this question',
    'delete_help' => 'Deleting a question doesn\'t affect the answers that the users did. But maybe you can <strong>change the status to draft</strong> instead. Once you delete a question, there is no going back. Please be certain.',
    'delete_confirmation_warning' => 'This action <strong>cannot</strong> be undone. This will permanently delete the <strong>:name</strong> question.',
    'delete_confirmation_button' => 'I understand the consequences, delete this question',

];
