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

final class RadioTest extends TestCase
{
    #[Test]
    public function it_should_correctly_render_with_defaults(): void
    {
        $view = $this->withViewErrors([])
            ->blade(
            '<x-forms.radio :name="$name" :value="$value" :label="$label"/>',
            ['name' => 'test', 'value' => 'my-value', 'label' => 'The Input Label']
        );

        $view->assertSeeText('The Input Label');
        $view->assertSee('name="test"', false);
        $view->assertSee('value="my-value"', false);

        $view->assertDontSee('checked', false);
    }

    #[Test]
    public function it_should_render_default_id_and_for(): void
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.radio :name="$name" :value="$value" :label="$label"/>',
                ['name' => 'test', 'value' => 'my-value', 'label' => 'The Input Label']
            );

        $view->assertSee('id="testmyValue', false);
        $view->assertSee('for="testmyValue', false);
    }

    #[Test]
    public function it_should_render_custom_id_and_for(): void
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.radio :name="$name" :value="$value" :label="$label" id="myUniqueId"/>',
                ['name' => 'test', 'value' => 'my-value', 'label' => 'The Input Label']
            );

        $view->assertSee('id="myUniqueId', false);
        $view->assertSee('for="myUniqueId', false);
    }

    #[Test]
    public function it_should_check_checkbox(): void
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.radio :name="$name" :value="$value" :label="$label" :checked="true"/>',
                ['name' => 'test', 'value' => 'my-value', 'label' => 'The Input Label']
            );

        $view->assertSee('checked', false);
    }

    #[Test]
    public function it_should_disable_checkbox(): void
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.radio :name="$name" :value="$value" :label="$label" :disabled="true"/>',
                ['name' => 'test', 'value' => 'my-value', 'label' => 'The Input Label']
            );

        $view->assertSee('disabled', false);
    }

    #[Test]
    public function it_should_render_error_message(): void
    {
        $view = $this->withViewErrors(['test' => 'The test field is required'])
            ->blade(
                '<x-forms.radio :name="$name" :value="$value" :label="$label"/>',
                ['name' => 'test', 'value' => 'my-value', 'label' => 'The Input Label']
            );

        $view->assertSee('The test field is required');
        $view->assertSee('class="error invalid-feedback"', false);
    }

    #[Test]
    #[DataProvider('provideAttributesThatShouldFail')]
    public function it_should_not_render_without_label(array $testAttributes): void
    {
        $this->expectException(ViewException::class);
        $this->withViewErrors([])
            ->blade(
                '<x-forms.radio :name="$name" :value="$value" :label="$label"/>',
                $testAttributes
            );
    }

    public static function provideAttributesThatShouldFail(): Generator
    {
        yield 'missing name' => [
            ['value' => 'my-value', 'label' => 'The Input Label']
        ];
        yield 'missing label' => [
            ['name' => 'test', 'value' => 'my-value']
        ];
        yield 'missing value' => [
            ['name' => 'test', 'label' => 'The Input Label']
        ];
    }

    #[Test]
    public function it_should_render_additional_classes(): void
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.radio :name="$name" :value="$value" :label="$label" :class="$class"/>',
                ['name' => 'test', 'value' => 'my-value', 'label' => 'The Input Label', 'class' => 'is-large is-rounded is-static']
            );

        $view->assertSee('is-large is-rounded is-static', false);
    }
}
