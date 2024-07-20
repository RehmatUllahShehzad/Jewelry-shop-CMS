<?php

namespace App\Http\Livewire\Admin\Catalog\Category;

use App\Http\Livewire\Traits\CanDeleteRecord;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;

class CategoryShowController extends CategoryAbstract
{
    use CanDeleteRecord;

    /**
     * @return array<mixed>
     */
    public function rules()
    {
        return [
            'category.name' => [
                'required',
                Rule::unique('categories', 'name')->ignore($this->category->id)->when($this->parent, function ($query) {
                    return $query->where('parent_id', $this->parent->id);
                }),
            ],
            'category.slug' => 'bail|nullable|unique:categories,slug,'.$this->category->id,
            'category.is_published' => 'required',
            'category.is_popular' => 'required',
            'images' => 'required',
        ];
    }

    public function render(): View
    {
        return $this->view('admin.catalog.category.category-show-controller');
    }

    /**
     * @return void
     */
    public function update()
    {
        $this->validate();

        $this->category->save();

        $this->updateImages();

        $this->notify(
            __('notifications.categories.updated'),
            'admin.catalog.category.index'
        );
    }

    public function delete(): void
    {
        $this->category->delete();

        $this->notify(
            __('notifications.categories.deleted'),
            'admin.catalog.category.index'
        );
    }

    /**
     * return field to verify for delete
     */
    public function getCanDeleteConfirmationField(): string
    {
        return $this->category->name;
    }
}
