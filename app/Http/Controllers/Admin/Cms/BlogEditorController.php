<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlogEditorController extends Controller
{
    public function index(Blog $blog): View
    {
        return $blog->getEditor();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, Blog $blog): Response
    {
        return $blog->saveEditorData($request);
    }

    /**
     * Templates for blog pages
     *
     * @param  Blog  $blog
     * @return array<mixed>
     */
    public function templates(Blog $blog)
    {
        return array_merge(
            $blog->loadBlocks(resource_path('views/frontend/theme/blocks'), 'Blocks'),
            $blog->loadBlocks(resource_path('views/frontend/theme/sections'), 'Sections'),
            $blog->loadBlocks(resource_path('views/frontend/theme/templates/blog'), 'Templates'),
        );
    }
}
