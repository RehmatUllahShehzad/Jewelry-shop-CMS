<?php

namespace App\Services\Admin;

use App\Models\Admin\Staff;
use App\Models\News;
use App\Traits\WithSaveImages;
use Exception;

class NewsService
{
    use WithSaveImages;

    private News $news;

    private Staff $author;

    /**
     * @var array<mixed>
     */
    private array $images = [];

    /**
     * Assigns author to news
     *
     * @param  Staff  $author
     * @return self
     */
    public function forStaff($author): self
    {
        $this->author = $author;

        return $this;
    }

    public function withModel(News $news): self
    {
        $this->news = $news;

        return $this;
    }

    public function getMediaModel(): News
    {
        return $this->news;
    }

    /**
     * @param  array<mixed>  $images
     */
    public function withImage(array $images = []): self
    {
        $this->images = $images;

        return $this;
    }

    public function save(): News
    {
        if (! $this->author instanceof Staff) {
            throw new Exception('No author provided');
        }

        $this->news->author_id = $this->author->id;
        $this->news->save();
        $this->updateImages();

        return $this->news;
    }
}
