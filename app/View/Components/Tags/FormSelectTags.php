<?php

namespace Gamify\View\Components\Tags;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormSelectTags extends Component
{
    public function __construct(
        public string $name,
        public array $availableTags,
        public array $selectedTags,
        public string $placeholder
    ) {
        //
    }

    public function render(): View
    {
        return view('components.tags.form-select-tags');
    }

    /**
     * Determine if the given tag is one of the currently selected tags.
     *
     * @param  string  $tag
     * @return bool
     */
    public function isSelected(string $tag): bool
    {
        return in_array($tag, $this->selectedTags);
    }
}
