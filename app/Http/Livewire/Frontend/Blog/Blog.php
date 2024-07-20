<?php

namespace App\Http\Livewire\Frontend\Blog;

use App\Models\Blog as BlogModel;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Blog extends Component
{
    public int $perPage = 5;

    public bool $hasMorePage;

    public function loadMore(): void
    {
        $this->perPage += $this->perPage;
    }

    public function render(): View
    {
        $blogs = BlogModel::published()->latest()->paginate($this->perPage);

        $this->hasMorePage = $blogs->hasMorePages();

        return view('frontend.blog.blog', compact('blogs'));
    }
}
