<?php

namespace App\Http\Livewire\Admin\Cms\News;

use App\Http\Livewire\Admin\Cms\CmsAbstract;
use App\Http\Livewire\Traits\HasImages;
use App\Http\Livewire\Traits\Notifies;
use App\Http\Livewire\Traits\RegistersDynamicListeners;
use App\Models\News;
use App\Rules\ImageDimensionsValidation;
use App\Services\Admin\NewsService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class NewsAbstract extends CmsAbstract
{
    use Notifies,
        WithFileUploads,
        HasImages,
        RegistersDynamicListeners;

    public News $news;

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
        return $this->news;
    }

    /**
     * Validation rules for news
     *
     * @return array<mixed>
     */
    protected function rules(): array
    {
        return [
            'news.title' => 'bail|required',
            'news.slug' => 'bail|nullable|unique:news,slug,'.$this->news->id,
            'news.meta_title' => 'bail|nullable',
            'news.meta_keywords' => 'bail|nullable',
            'news.meta_description' => 'bail|nullable',
            'news.raw_meta' => 'bail|nullable',
            'news.is_published' => ['bail', Rule::in([true, false])],
            'images' => 'required',
            'images.*' => (new ImageDimensionsValidation())->height(500)->width(500),
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
     * Save the news in database
     *
     * @return void
     */
    public function save(NewsService $newsService): void
    {
        $this->validate();
        try {
            $newsService->withModel($this->news)
                ->forStaff(auth_staff())
                ->withImage($this->images)
                ->save();

            $type = $this->news->wasRecentlyCreated ? 'created' : 'updated';

            $this->notify(
                "News {$type} successfully.",
                'admin.cms.news.index'
            );
        } catch (\Throwable $th) {
            $this->notify($th->getMessage(), level: 'error');
        }
    }
}
