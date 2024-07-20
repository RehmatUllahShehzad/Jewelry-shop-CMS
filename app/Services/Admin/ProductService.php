<?php

namespace App\Services\Admin;

use App\Models\Admin\Staff;
use App\Models\Product;
use App\Traits\WithSaveImages;
use Exception;
use Livewire\TemporaryUploadedFile;

class ProductService
{
    use WithSaveImages;

    private Product $product;

    private Staff $staff;

    private TemporaryUploadedFile|string|null $bannerImage;

    /**
     * @var array<mixed>
     */
    private array $categories = [];

    /**
     * @var array<mixed>
     */
    private array $images = [];

    public static function makeFrom(Product $product): self
    {
        return (new self())->withModel($product);
    }

    public function forStaff(Staff $staff): self
    {
        $this->staff = $staff;

        return $this;
    }

    public function withModel(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getMediaModel(): Product
    {
        return $this->product;
    }

    /**
     * @param  array<mixed>  $categories
     */
    public function withCategory(array $categories = []): self
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @param  array<mixed>  $images
     */
    public function withImage(array $images = []): self
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @param  mixed  $bannerImage
     */
    public function withBannerImage($bannerImage): self
    {
        $this->bannerImage = $bannerImage;

        return $this;
    }

    public function save(): Product
    {
        if (! $this->staff instanceof Staff) {
            throw new Exception('No staff provided');
        }

        $this->product->staff_id = $this->staff->id;

        $this->product->save();

        $this->updateImages();

        if ($this->bannerImage instanceof TemporaryUploadedFile) {
            $this->product->clearMediaCollection('banner');
            $this->product->addMedia($this->bannerImage->getRealPath())
                ->usingName($this->bannerImage->getClientOriginalName())
                ->toMediaCollection('banner');

            $this->bannerImage = $this->product->getFirstMedia('banner');
        }

        if ($this->categories) {
            $this->product->categories()->sync(array_values($this->categories));
        }

        return $this->product;
    }
}
