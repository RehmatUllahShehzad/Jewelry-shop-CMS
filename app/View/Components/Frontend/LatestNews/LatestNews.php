<?php

namespace App\View\Components\Frontend\LatestNews;

use App\Models\News;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class LatestNews extends Component
{
    public Collection $news;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->news = News::published()->latest()->take(3)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.frontend.latest-news.latest-news');
    }
}
