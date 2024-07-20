<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Traits\EditorPlaceholders;

class PageController extends Controller
{
    use EditorPlaceholders;

    /**
     * Display a listing of the resource.
     *
     * @param  Page  $page
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(Page $page = null)
    {
        if (! $page) {
            $page = Page::findOrFail(Page::HOME_PAGE_ID)->load('publishedSlides');
        }

        abort_if(! $page->isActive(), 404);

        $this->setPlaceholders($page);

        return view('frontend.pages.index', compact('page'));
    }
}
