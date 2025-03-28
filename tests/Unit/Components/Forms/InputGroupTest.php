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

namespace Tests\Unit\Components\Forms;

use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Tests\Unit\Components\BaseInputComponentTests;

final class InputGroupTest extends TestCase
{
    #[Test]
    public function it_should_render(): void
    {
        $view = $this->blade(
                '<x-forms.input-group></x-forms.input-group>'
            );

        $view->assertSee('class="form-group"', false);
    }

    #[Test]
    public function it_should_set_class_on_errors(): void
    {
        $view = $this->blade(
                '<x-forms.input-group :hasError="true"></x-forms.input-group>'
            );

        $view->assertSee('class="form-group has-error"', false);
    }

    #[Test]
    public function it_should_pass_additional_classes_to_form_group(): void
    {
        $view = $this->blade(
                '<x-forms.input-group :class="$class"></x-forms.input-group>',
                ['class' => 'is-large is-rounded is-static']
            );

        $view->assertSee('class="form-group is-large is-rounded is-static"', false);
    }
}
