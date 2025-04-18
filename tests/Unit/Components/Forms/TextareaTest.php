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
use Illuminate\View\ViewException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Tests\Unit\Components\BaseInputComponentTests;

final class TextareaTest extends TestCase
{

    #[Test]
    public function it_should_render(): void
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.textarea :label="$label" :name="$name"/>',
                ['label' => 'The Input Label', 'name' => 'test']
            );

        $view->assertSee('The Input Label');
        $view->assertSee('name="test"', false);
    }

    #[Test]
    public function it_should_render_id_and_for(): void
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.textarea :label="$label" :name="$name"/>',
                ['label' => 'The Input Label', 'name' => 'test_input']
            );

        $view->assertSee('id="testInput', false);
        $view->assertSee('for="testInput', false);
    }

    #[Test]
    public function it_should_render_with_provided_id(): void
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.textarea :label="$label" :name="$name" :id="$id"/>',
                ['label' => 'The Input Label', 'name' => 'test_input', 'id' => 'custom_id']
            );

        $view->assertSee('id="custom_id"', false);
        $view->assertSee('for="custom_id"', false);
    }

    #[Test]
    public function it_should_render_help_message(): void
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.textarea :label="$label" :name="$name" :help="$help"/>',
                ['label' => 'The Input Label', 'name' => 'test_input', 'help' => 'This is the help message']
            );

        $view->assertSee('This is the help message');
    }

    #[Test]
    public function it_should_pass_additional_classes(): void
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.input :label="$label" :name="$name" :class="$class"></x-forms.input>',
                ['label' => 'The Input Label', 'name' => 'test', 'class' => 'is-large is-rounded is-static']
            );

        $view->assertSee('class="form-control is-large is-rounded is-static"', false);
    }

    #[Test]
    public function it_should_render_error_message(): void
    {
        $view = $this->withViewErrors(['test' => 'The test field is required'])
            ->blade(
                '<x-forms.textarea :label="$label" :name="$name"/>',
                ['label' => 'The Input Label', 'name' => 'test']
            );

        $view->assertSee('The test field is required');
        $view->assertSee('class="error invalid-feedback"', false);
    }

    #[Test]
    public function it_should_not_render_without_label(): void
    {
        $this->expectException(ViewException::class);
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.textarea :name="$name"/>',
                ['name' => 'test']
            );
    }

    #[Test]
    public function it_should_not_render_without_name(): void
    {
        $this->expectException(ViewException::class);
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.textarea :label="$label"/>',
                ['label' => 'The Input Label']
            );
    }

    #[Test]
    public function it_should_render_as_required(): void
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.textarea :label="$label" :name="$name" :required="true"/>',
                ['label' => 'The Input Label', 'name' => 'test']
            );

        $view->assertSee('required');
    }

    #[Test]
    public function it_should_render_as_readonly(): void
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.textarea :label="$label" :name="$name" :readonly="true"/>',
                ['label' => 'The Input Label', 'name' => 'test']
            );

        $view->assertSee('readonly');
    }

    #[Test]
    public function it_should_render_as_disabled(): void
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.textarea :label="$label" :name="$name" :disabled="true"/>',
                ['label' => 'The Input Label', 'name' => 'test']
            );

        $view->assertSee('disabled');
    }
}
