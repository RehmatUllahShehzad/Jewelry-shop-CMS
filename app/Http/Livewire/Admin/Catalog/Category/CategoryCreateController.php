<?php

namespace App\Http\Livewire\Admin\Catalog\Category;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;

class CategoryCreateController extends CategoryAbstract
{
    public function mount(): void
    {
        $this->category = new Category(['is_published' => false, 'is_popular' => false]);
    }

    /**
     * @return array<mixed>
     */
    public function rules()
    {
        return [
            'category.name' => [
                'required',
                Rule::unique('categories', 'name')->when($this->parent, function ($query) {
                    return $query->where('parent_id', $this->parent->id);
                }),
            ],
            'category.slug' => 'bail|unique:categories,slug,'.$this->category->id,
            'category.is_published' => 'required',
            'category.is_popular' => 'required',
            'images' => 'required',
        ];
    }

    public function render(): View
    {
        return $this->view('admin.catalog.category.category-create-controller');
    }

    public function store(): void
    {
        $this->validate();

        $this->category->parent_id = $this->parent->id ?? null;

        $this->category->save();

        $this->updateImages();

        $this->notify(
            __('notifications.categories.added'),
            'admin.catalog.category.index'
        );
    }
}
