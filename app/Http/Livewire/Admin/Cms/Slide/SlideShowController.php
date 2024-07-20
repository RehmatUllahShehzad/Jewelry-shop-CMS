<?php

namespace App\Http\Livewire\Admin\Cms\Slide;

use App\Http\Livewire\Traits\CanDeleteRecord;
use App\Models\Category;
use App\Models\Page;

class SlideShowController extends SlideAbstract
{
    use CanDeleteRecord;

    /**
     * Mount the component
     *
     * @return void
     */
    public function mount(): void
    {
        $this->slideable = ($this->type == 'page' ? Page::class : Category::class)::find($this->slideableId);
    }

    public function delete(): void
    {
        $this->slide->delete();

        $this->notify(
            __('slide.delete'),
            'admin.cms.slides.show',
            [$this->type, $this->slideable->id]
        );
    }

    /**
     * return field to verify for delete
     */
    public function getCanDeleteConfirmationField(): string
    {
        return $this->slide->title;
    }
}
