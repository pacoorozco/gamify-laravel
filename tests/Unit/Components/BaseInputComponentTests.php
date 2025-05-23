<?php

namespace Tests\Unit\Components;

use Illuminate\View\ViewException;

trait BaseInputComponentTests
{
    /** @test */
    public function input_component_renders(): void
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.'.$this->component.' :label="$label" :name="$name"></x-forms.'.$this->component.'>',
                ['label' => 'The Input Label', 'name' => 'test']
            );

        $view->assertSee('The Input Label');
        $view->assertSee('name="test"', false);
    }

    /** @test */
    public function id_and_for_are_rendered(): void
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.'.$this->component.' :label="$label" :name="$name"></x-forms.'.$this->component.'>',
                ['label' => 'The Input Label', 'name' => 'test_input']
            );

        $view->assertSee('id="testInput', false);
        $view->assertSee('for="testInput', false);
    }

    /** @test */
    public function input_component_renders_error_message(): void
    {
        $view = $this->withViewErrors(['test' => 'The test field is required'])
            ->blade(
                '<x-forms.'.$this->component.' :label="$label" :name="$name"></x-forms.'.$this->component.'>',
                ['label' => 'The Input Label', 'name' => 'test']
            );

        $view->assertSee('The test field is required');
        $view->assertSee('class="error invalid-feedback"', false);
    }

    /** @test */
    public function input_component_wont_render_without_label(): void
    {
        $this->expectException(ViewException::class);
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.'.$this->component.' :name="$name"></x-forms.'.$this->component.'>',
                ['name' => 'test']
            );
    }

    /** @test */
    public function input_is_required(): void
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.'.$this->component.' :label="$label" :name="$name" :required="true"></x-forms.'.$this->component.'>',
                ['label' => 'The Input Label', 'name' => 'test']
            );

        $view->assertSee('required');
    }

    /** @test */
    public function input_is_readonly(): void
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.'.$this->component.' :label="$label" :name="$name" :readonly="true"></x-forms.'.$this->component.'>',
                ['label' => 'The Input Label', 'name' => 'test']
            );

        $view->assertSee('readonly');
    }

    /** @test */
    public function input_is_disabled(): void
    {
        $view = $this->withViewErrors([])
            ->blade(
                '<x-forms.'.$this->component.' :label="$label" :name="$name" :disabled="true"></x-forms.'.$this->component.'>',
                ['label' => 'The Input Label', 'name' => 'test']
            );

        $view->assertSee('disabled');
    }
}
