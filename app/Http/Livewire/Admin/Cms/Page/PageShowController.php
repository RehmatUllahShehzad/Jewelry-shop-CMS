<?php

namespace App\Http\Livewire\Admin\Cms\Page;

use App\Http\Livewire\Traits\CanDeleteRecord;

class PageShowController extends PageAbstract
{
    use CanDeleteRecord;

    public function delete(): void
    {
        $this->page->delete();

        $this->notify(__('pages.delete'), 'admin.cms.pages.index');
    }

    /**
     * return field to verify for delete
     */
    public function getCanDeleteConfirmationField(): string
    {
        return $this->page->slug;
    }
}
