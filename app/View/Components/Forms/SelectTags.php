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

namespace Gamify\View\Components\Forms;

use Cviebrock\EloquentTaggable\Services\TagService;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectTags extends Component
{
    public function __construct(
        private readonly TagService $tagService,
        public string               $name,
        public array                $selectedTags,
        public string               $placeholder,
        public string               $help,
        public string               $label,
    )
    {
    }

    public function render(): View
    {
        return view('components.forms.select-tags')
            ->with('availableTags', $this->tagService->getAllTagsArrayNormalized());
    }

    /**
     * Determine if the given tag is one of the currently selected tags.
     */
    public function isSelected(string $tag): bool
    {
        return in_array($tag, $this->selectedTags);
    }
}
