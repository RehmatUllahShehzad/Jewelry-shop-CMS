<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Traits\EditorPlaceholders;

class NewsController extends Controller
{
    use EditorPlaceholders;

    /**
     * Handle the incoming request.
     *
     * @param  News  $news
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(News $news)
    {
        abort_if(! $news->isPublished(), 404);

        $this->setPlaceholders($news);

        return view('frontend.press.news-detail', compact('news'));
    }
}
