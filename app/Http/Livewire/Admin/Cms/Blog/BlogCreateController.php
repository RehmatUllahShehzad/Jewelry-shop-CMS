<?php

namespace App\Http\Livewire\Admin\Cms\Blog;

use App\Models\Blog;

class BlogCreateController extends BlogAbstract
{
    /**
     * Mount the component
     *
     * @return void
     */
    public function mount(): void
    {
        $this->blog = new Blog(['is_published' => true]);
    }
}
