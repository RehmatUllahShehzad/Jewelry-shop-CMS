<?php

namespace App\Http\Livewire\Admin\Cms\News;

use App\Http\Livewire\Admin\Cms\CmsAbstract;
use App\Http\Livewire\Traits\ResetsPagination;
use App\Models\News;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;

class NewsIndexController extends CmsAbstract
{
    use WithPagination;
    use ResetsPagination;

    public string $showTrashed = '';

    public string $search = '';

    public function getNewsProperty(): LengthAwarePaginator
    {
        return News::query()
            ->with('thumbnail')
            ->when($this->search, fn ($q) => $q->search($this->search))
            ->when($this->showTrashed, fn ($q) => $q->withTrashed())
            ->paginate(10);
    }

    public function render(): View
    {
        return $this->view('admin.cms.news.news-index-controller');
    }
}
