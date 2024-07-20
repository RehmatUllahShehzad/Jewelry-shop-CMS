<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\EditorPlaceholders;

class CategoryController extends Controller
{
    use EditorPlaceholders;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(Category $category, Category $subCategory = null)
    {
        $category = $subCategory ?? $category;

        if ($category->id == Category::OBJETS_ID) {
            $category->load('publishedSlides');
        }

        abort_if(! $category->isPublished(), 404);

        $this->setPlaceholders($category);

        return view('frontend.categories.index', compact('category'));
    }
}
