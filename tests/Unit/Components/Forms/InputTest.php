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

final class InputTest extends TestCase
{
    use BaseInputComponentTests;

    protected string $component = 'input';

    #[Test]
    #[DataProvider('provideInputTypesToTest')]
    public function it_should_set_provided_type(
        string|null $type,
        string $expected
    ): void
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.input :label="$label" :name="$name" :type="$type"></x-forms.input>',
                ['label' => 'The Input Label', 'name' => 'test', 'type' => $type]
            );

        $view->assertSee(html_entity_decode($expected));
    }

    public static function provideInputTypesToTest(): Generator
    {
        yield 'empty' => [
            'type' => null,
            'expected' => 'text',
        ];

        yield 'password' => [
            'type' => 'password',
            'expected' => 'password',
        ];

        yield 'date' => [
            'type' => 'date',
            'expected' => 'date',
        ];

        yield 'email' => [
            'type' => 'email',
            'expected' => 'email',
        ];
    }

    #[Test]
    public function it_should_pass_additional_classes_to_input(): void
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.input :label="$label" :name="$name" :options="$options" :class="$class"></x-forms.input>',
                ['label' => 'The Input Label', 'name' => 'test', 'options' => ['first' => 'First option'], 'class' => 'is-large is-rounded is-static']
            );

        $view->assertSee('class="form-control is-large is-rounded is-static"', false);
    }
}
