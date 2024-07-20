<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PageEditorController extends Controller
{
    public function index(Page $page): View
    {
        return $page->getEditor();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, Page $page): Response
    {
        return $page->saveEditorData($request);
    }

    /**
     * Templates for pages
     *
     * @param  Page  $page
     * @return array<mixed>
     */
    public function templates(Page $page)
    {
        return array_merge(
            $page->loadBlocks(resource_path('views/frontend/theme/blocks'), 'Blocks'),
            $page->loadBlocks(resource_path('views/frontend/theme/sections'), 'Sections'),
            $page->loadBlocks(resource_path('views/frontend/theme/templates/pages'), 'Templates'),
        );
    }
}
