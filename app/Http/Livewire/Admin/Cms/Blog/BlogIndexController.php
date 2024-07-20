<?php

namespace App\Http\Livewire\Admin\Cms\Blog;

use App\Http\Livewire\Admin\Cms\CmsAbstract;
use App\Http\Livewire\Traits\ResetsPagination;
use App\Models\Blog;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;

class BlogIndexController extends CmsAbstract
{
    use WithPagination;
    use ResetsPagination;

    public string $search = '';

    public bool $showTrashed = false;

    public function getBlogsProperty(): LengthAwarePaginator
    {
        return Blog::query()
            ->with('thumbnail')
            ->when($this->search, fn ($q) => $q->search($this->search))
            ->when($this->showTrashed, fn ($q) => $q->withTrashed())
            ->paginate(10);
    }

    public function render(): View
    {
        return $this->view('admin.cms.blog.blog-index-controller');
    }
}
