<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NewsEditorController extends Controller
{
    public function index(News $news): View
    {
        return $news->getEditor();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, News $news): Response
    {
        return $news->saveEditorData($request);
    }

    /**
     * Templates for news pages
     *
     * @param  News  $news
     * @return array<mixed>
     */
    public function templates(News $news)
    {
        return array_merge(
            $news->loadBlocks(resource_path('views/frontend/theme/blocks'), 'Blocks'),
            $news->loadBlocks(resource_path('views/frontend/theme/sections'), 'Sections'),
            $news->loadBlocks(resource_path('views/frontend/theme/templates/news'), 'Templates'),
        );
    }
}
