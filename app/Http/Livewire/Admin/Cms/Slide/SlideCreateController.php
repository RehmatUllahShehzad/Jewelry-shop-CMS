<?php

namespace App\Http\Livewire\Admin\Cms\Slide;

use App\Models\Category;
use App\Models\Page;
use App\Models\Slide;

class SlideCreateController extends SlideAbstract
{
    /**
     * Mount the component
     *
     * @return void
     */
    public function mount(): void
    {
        $this->slideable = ($this->type == 'page' ? Page::class : Category::class)::find($this->slideableId);

        $this->slide = new Slide(['is_published' => true]);
    }
}
