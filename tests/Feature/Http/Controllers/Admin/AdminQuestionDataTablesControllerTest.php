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

namespace Tests\Feature\Http\Controllers\Admin;

use Gamify\Enums\Roles;
use Gamify\Models\Question;
use Gamify\Models\User;
use Tests\Feature\TestCase;

class AdminQuestionDataTablesControllerTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var User user */
        $user = User::factory()->create();

        $this->user = $user;
    }

    /** @test */
    public function admins_should_get_data_tables_data(): void
    {
        $this->user->role = Roles::Admin();

        $questions = Question::factory()
            ->count(3)
            ->create();

        $this
            ->actingAs($this->user)
            ->ajaxGet(route('admin.questions.data'))
            ->assertSuccessful()
            ->assertJsonCount($questions->count(), 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'name',
                        'status',
                        'publication_date',
                        'actions',
                        'tags',
                    ],
                ],
            ]);
    }

    /** @test */
    public function users_should_not_get_data_tables_data(): void
    {
        $this
            ->actingAs($this->user)
            ->ajaxGet(route('admin.questions.data'))
            ->assertForbidden();
    }

    /** @test */
    public function it_should_fail_if_ajax_is_not_used(): void
    {
        $this
            ->get(route('admin.questions.data'))
            ->assertForbidden();
    }
}
