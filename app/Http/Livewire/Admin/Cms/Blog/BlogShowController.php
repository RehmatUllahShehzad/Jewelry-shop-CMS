<?php

namespace App\Http\Livewire\Admin\Cms\Blog;

use App\Http\Livewire\Traits\CanDeleteRecord;

class BlogShowController extends BlogAbstract
{
    use CanDeleteRecord;

    public function delete(): void
    {
        $this->blog->delete();
        $this->notify('Blog deleted successfully.', 'admin.cms.blogs.index');
    }

    /**
     * return field to verify for delete
     */
    public function getCanDeleteConfirmationField(): string
    {
        return $this->blog->slug;
    }
}
