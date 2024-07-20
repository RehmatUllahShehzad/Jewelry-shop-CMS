<?php

namespace App\Http\Livewire\Admin\Catalog\Category;

use App\Http\Livewire\Admin\Catalog\CatalogAbstract;
use App\Http\Livewire\Traits\HasImages;
use App\Http\Livewire\Traits\Notifies;
use App\Models\Category;
use Livewire\WithFileUploads;

class CategoryAbstract extends CatalogAbstract
{
    use WithFileUploads,
        HasImages,
        Notifies;

    public Category $category;

    public ?Category $parent = null;

    /**
     * @return array<mixed>
     */
    protected function getListeners()
    {
        return array_merge(
            [],
            $this->getHasImagesListeners()
        );
    }

    public function getMediaModel(): Category
    {
        return $this->category;
    }
}
