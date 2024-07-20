<?php

namespace App\Http\Livewire\Admin\Cms\Blog;

use App\Http\Livewire\Admin\Cms\CmsAbstract;
use App\Http\Livewire\Traits\HasImages;
use App\Http\Livewire\Traits\Notifies;
use App\Http\Livewire\Traits\RegistersDynamicListeners;
use App\Models\Blog;
use App\Rules\ImageDimensionsValidation;
use App\Services\Admin\BlogService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

abstract class BlogAbstract extends CmsAbstract
{
    use Notifies;
    use WithFileUploads;
    use HasImages;
    use RegistersDynamicListeners;

    public Blog $blog;

    /**
     * @return array<string,string>
     */
    protected function getListeners(): array
    {
        return array_merge(
            $this->getDynamicListeners(),
            $this->getHasImagesListeners()
        );
    }

    public function getMediaModel(): Model
    {
        return $this->blog;
    }

    /**
     * Validation rules for blog
     *
     * @return array<mixed>
     */
    protected function rules(): array
    {
        return [
            'blog.title' => 'bail|required',
            'blog.slug' => 'bail|nullable|unique:blogs,slug,'.$this->blog->id,
            'blog.meta_title' => 'bail|nullable',
            'blog.meta_keywords' => 'bail|nullable',
            'blog.meta_description' => 'bail|nullable',
            'blog.raw_meta' => 'bail|nullable',
            'blog.published_at' => 'date',
            'blog.is_published' => ['bail', Rule::in([true, false])],
            'images' => 'required',
            'images.*' => (new ImageDimensionsValidation())->height(255)->width(445),
        ];
    }

    /**
     * Custom attribute name's mapping
     *
     * @return array<mixed>
     */
    protected function validationAttributes()
    {
        return collect($this->images)
            ->mapWithKeys(fn ($value, $key) => ["images.{$key}" => 'image'])
            ->toArray();
    }

    /**
     * Save the blog in database
     *
     * @return void
     */
    public function save(BlogService $blogService): void
    {
        $this->validate();

        try {
            $blogService->withModel($this->blog)
                ->forStaff(auth_staff())
                ->withImage($this->images)
                ->save();

            $type = $this->blog->wasRecentlyCreated ? 'created' : 'updated';

            $this->notify("Blog {$type} successfully.", 'admin.cms.blogs.index');
        } catch (\Throwable $th) {
            $this->notify($th->getMessage(), level: 'error');
        }
    }

    public function render(): View
    {
        $title = $this->blog->id ? 'edit' : 'create';

        return $this->view('admin.cms.blog.blog-form')
            ->with('blogTitle', "blogs.{$title}.title");
    }
}
