<?php

namespace App\Http\Livewire\Admin\Cms\Slide;

use App\Http\Livewire\Admin\Cms\CmsAbstract;
use App\Http\Livewire\Traits\ResetsPagination;
use App\Models\Category;
use App\Models\Page;
use App\View\Components\Admin\Layouts\SubMasterLayout;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;

class SlideIndexController extends CmsAbstract
{
    use WithPagination;
    use ResetsPagination;

    public Page|Category $slideable;

    public string $type;

    public string $search = '';

    public bool $showTrashed = false;

    public int $slideableId;

    public function mount(): void
    {
        $this->slideable = ($this->type == 'page' ? Page::class : Category::class)::find($this->slideableId);
    }

    public function getPageSlidesProperty(): LengthAwarePaginator
    {
        return $this->slideable->slides()
            ->with('thumbnail')
            ->when($this->search, fn ($q) => $q->search($this->search))
            ->when($this->showTrashed, fn ($q) => $q->withTrashed())
            ->latest()
            ->paginate(10);
    }

    public function render(): View
    {
        $menuName = $this->type == 'page' ? 'cms' : 'catalog';

        return view('admin.cms.slide.slide-index-controller')
            ->layout(SubMasterLayout::class, [
                'menuName' => $menuName,
            ]);
    }
}
