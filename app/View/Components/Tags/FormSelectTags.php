<?php

namespace Gamify\View\Components\Tags;

use Cviebrock\EloquentTaggable\Services\TagService;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormSelectTags extends Component
{
    public function __construct(
        private TagService $tagService,
        public string $name,
        public array $selectedTags,
        public string $placeholder
    ) {
        //
    }

    public function render(): View
    {
        return view('components.tags.form-select-tags')
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
