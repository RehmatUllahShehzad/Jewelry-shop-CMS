<?php

namespace App\Services\Admin;

use App\Models\Admin\Staff;
use App\Models\Blog;
use App\Traits\WithSaveImages;
use Exception;

class BlogService
{
    use WithSaveImages;

    private Blog $blog;

    private Staff $author;

    /**
     * @var array<mixed>
     */
    private array $images = [];

    /**
     * Assigns author to the blog
     *
     * @param  Staff  $author
     * @return self
     */
    public function forStaff($author): self
    {
        $this->author = $author;

        return $this;
    }

    public function withModel(Blog $blog): self
    {
        $this->blog = $blog;

        return $this;
    }

    public function getMediaModel(): Blog
    {
        return $this->blog;
    }

    /**
     * @param  array<mixed>  $images
     */
    public function withImage(array $images = []): self
    {
        $this->images = $images;

        return $this;
    }

    public function save(): Blog
    {
        if (! $this->author instanceof Staff) {
            throw new Exception('No author provided');
        }

        $this->blog->author_id = $this->author->id;

        $this->blog->save();

        $this->updateImages();

        return $this->blog;
    }
}
