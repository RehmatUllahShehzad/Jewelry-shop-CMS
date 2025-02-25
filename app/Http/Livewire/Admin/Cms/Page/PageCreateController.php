<?php

namespace App\Http\Livewire\Admin\Cms\Page;

use App\Models\Page;

class PageCreateController extends PageAbstract
{
    /**
     * Mount the component
     *
     * @return void
     */
    public function mount(): void
    {
        $this->page = new Page(['is_published' => true]);
    }
}
