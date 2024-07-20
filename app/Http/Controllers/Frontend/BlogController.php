<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Traits\EditorPlaceholders;
use Illuminate\Contracts\View\View;

class BlogController extends Controller
{
    use EditorPlaceholders;

    /**
     * Handle the incoming request.
     *
     * @param  Blog  $blog
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(Blog $blog): View
    {
        abort_if(! $blog->isPublished(), 404);

        $this->setPlaceholders($blog);

        return view('frontend.blog.index', compact('blog'));
    }
}
