<?php

namespace App\Http\Livewire\Frontend\Press;

use App\Models\News;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Press extends Component
{
    public int $perPage = 5;

    public bool $hasMorePage;

    public function loadMore(): void
    {
        $this->perPage += $this->perPage;
    }

    public function render(): View
    {
        $news = News::published()->latest()->paginate($this->perPage);

        $this->hasMorePage = $news->hasMorePages();

        return view('frontend.press.press', ['news' => $news]);
    }
}
