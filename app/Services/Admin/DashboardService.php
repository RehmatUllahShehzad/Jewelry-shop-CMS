<?php

namespace App\Services\Admin;

use App\Models\Admin\Staff;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;

class DashboardService
{
    /**
     * Get required data for dashboard
     *
     * @return array<mixed>
     */
    public function getData()
    {
        return [
            'totalUsers' => $this->getUsersCount(),
            'totalCategories' => $this->getCategoriesCount(),
            'totalProducts' => $this->getProductsCount(),
            'totalBlogs' => $this->getBlogsCount(),
        ];
    }

    public function getUsersCount(): int
    {
        return Staff::count();
    }

    public function getCategoriesCount(): int
    {
        return Category::count();
    }

    public function getProductsCount(): int
    {
        return Product::count();
    }

    public function getBlogsCount(): int
    {
        return Blog::count();
    }
}
