<?php

namespace App\Http\Livewire\Admin\Catalog\Product;

use App\Services\Admin\ProductService;
use Illuminate\Contracts\View\View;

class ProductCreateController extends ProductAbstract
{
    /**
     * @return void
     */
    public function store(ProductService $productService)
    {
        $this->validate();

        try {
            $productService->withModel($this->product)
                ->forStaff(auth_staff())
                ->withCategory($this->categories->pluck('id')->toArray())
                ->withImage($this->images)
                ->withBannerImage($this->bannerImage)
                ->save();

            $this->notify(
                __('notifications.product.created'),
                'admin.catalog.product.index'
            );
        } catch (\Throwable $th) {
            $this->notify($th->getMessage(), level: 'error');
        }
    }

    public function render(): View
    {
        return $this->view('admin.catalog.product.product-create-controller');
    }
}
