<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    /**
     * __invoke
     *
     * @param  Category  $category
     * @param  Category  $subCategory
     * @param  Product  $product
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(Category $category, Category $subCategory, Product $product): View
    {
        return view('frontend.products.index', compact('product'));
    }
}
