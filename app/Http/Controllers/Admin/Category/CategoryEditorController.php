<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryEditorController extends Controller
{
    public function index(Category $category): View
    {
        return $category->getEditor();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, Category $category): Response
    {
        return $category->saveEditorData($request);
    }

    /**
     * Templates for category pages
     *
     * @param  Category  $category
     * @return array<mixed>
     */
    public function templates(Category $category)
    {
        $category_page = $category->parent_id ? 'sub-category' : 'category';

        return array_merge(
            $category->loadBlocks(resource_path('views/frontend/theme/blocks'), 'Blocks'),
            $category->loadBlocks(resource_path('views/frontend/theme/sections'), 'Sections'),
            $category->loadBlocks(resource_path('views/frontend/theme/templates/'.$category_page), 'Templates'),
        );
    }
}
