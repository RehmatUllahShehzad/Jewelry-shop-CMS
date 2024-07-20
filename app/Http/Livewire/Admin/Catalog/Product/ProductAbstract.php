<?php

namespace App\Http\Livewire\Admin\Catalog\Product;

use App\Http\Livewire\Admin\Catalog\CatalogAbstract;
use App\Http\Livewire\Traits\HasCategories;
use App\Http\Livewire\Traits\HasImages;
use App\Http\Livewire\Traits\Notifies;
use App\Http\Livewire\Traits\RegistersDynamicListeners;
use App\Models\Category;
use App\Models\Product;
use App\Rules\RichTextRequiredRule;
use Illuminate\Database\Eloquent\Model;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

abstract class ProductAbstract extends CatalogAbstract
{
    use WithFileUploads;
    use Notifies;
    use HasImages;
    use HasCategories;
    use RegistersDynamicListeners;

    public Product $product;

    public int $maxFileSize = 5; //file size in MBs

    public int $maxFiles = 3; //number of images allowed in product

    public TemporaryUploadedFile|string|null $bannerImage = null;

    public function mount(): void
    {
        $this->product = new Product();
    }

    /**
     * @return array<string,string>
     */
    protected function getListeners()
    {
        return array_merge(
            $this->getDynamicListeners(),
            $this->getHasImagesListeners()
        );
    }

    public function getMediaModel(): Model
    {
        return $this->product;
    }

    /**
     * Define the validation rules.
     *
     * @return array<string,mixed>
     */
    public function rules()
    {
        return [
            'images' => 'required',
            'categories' => 'bail|required',
            'product.title' => 'bail|required|max:100',
            'product.description' => [
                'bail',
                'required',
                'max:1000',
                new RichTextRequiredRule(
                    min: 10,
                    max: 1000
                ),
            ],
            'product.specifications' => [
                'bail',
                'required',
                'max:1000',
                new RichTextRequiredRule(
                    min: 10,
                    max: 1000
                ),
            ],
            'product.materials' => [
                'bail',
                'required',
                'max:1000',
                new RichTextRequiredRule(
                    min: 4,
                    max: 1000
                ),
            ],
            'product.is_published' => 'bail|nullable',
            'bannerImage' => 'nullable',
        ];
    }

    public function getBannerImagePreviewProperty(): string|null
    {
        if (! $this->bannerImage) {
            return null;
        }

        return $this->bannerImage instanceof TemporaryUploadedFile ? $this->bannerImage->temporaryUrl() : $this->bannerImage;
    }

    public function removeBannerImage(): void
    {
        if ($this->bannerImage instanceof TemporaryUploadedFile) {
            $this->bannerImage->delete();
        }

        $this->bannerImage = null;
    }

    /**
     * The product model for the product we want to show.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCategoriesProperty()
    {
        return Category::select('id', 'name')->get();
    }
}
