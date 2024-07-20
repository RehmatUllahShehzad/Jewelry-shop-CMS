<?php

namespace App\Http\Livewire\Admin\Catalog\Product;

use App\Http\Livewire\Traits\CanDeleteRecord;
use App\Services\Admin\ProductService;
use Illuminate\Contracts\View\View;

class ProductShowController extends ProductAbstract
{
    use CanDeleteRecord;

    /**
     * Called when the component has been mounted.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->bannerImage = $this->product->bannerImageUrl;
    }

    /**
     * @return void
     */
    public function update(ProductService $productService)
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
                __('notifications.product.updated'),
                'admin.catalog.product.index'
            );
        } catch (\Throwable $th) {
            $this->notify($th->getMessage(), level: 'error');
        }
    }

    public function render(): View
    {
        return $this->view('admin.catalog.product.product-show-controller');
    }

    public function delete(): void
    {
        $this->product->delete();

        $this->notify(trans('notifications.product.deleted'), 'admin.catalog.product.index');
    }

    /**
     * return field to verify for delete
     */
    public function getCanDeleteConfirmationField(): string
    {
        return $this->product->title;
    }
}
