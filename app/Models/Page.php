<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaraEditor\App\Contracts\Editable;
use LaraEditor\App\Traits\EditableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property-read Collection $media
 */
class Page extends Model implements Editable, HasMedia
{
    use HasFactory,
        HasSlug,
        EditableTrait,
        InteractsWithMedia,
        SoftDeletes;

    const HOME_PAGE_ID = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Get the page slides.
     */
    public function slides(): MorphMany
    {
        return $this->morphMany(Slide::class, 'slideable');
    }

    /**
     * Get the published page slides.
     */
    public function publishedSlides(): MorphMany
    {
        return $this->slides()->published();
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(100)
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getEditorStoreUrl(): ?string
    {
        return route('admin.cms.pages.editor.store', $this);
    }

    public function getEditorLoadUrl(): ?string
    {
        return route('admin.cms.pages.editor.index', $this);
    }

    public function getEditorTemplatesUrl(): ?string
    {
        return route('admin.cms.pages.editor.templates', $this);
    }

    public function scopePublished(Builder $builder): Builder
    {
        return $builder->where('is_published', true);
    }

    public function scopeNotPublished(Builder $builder): Builder
    {
        return $builder->where('is_published', false);
    }

    public function scopeSearch(Builder $builder, string $query): Builder
    {
        return $builder->where(function (Builder $builder) use ($query) {
            $query = "%{$query}%";

            $builder->where('title', 'like', $query);
            $builder->orWhere('slug', 'like', $query);
            $builder->orWhere('meta_title', 'like', $query);
            $builder->orWhere('meta_keywords', 'like', $query);
            $builder->orWhere('meta_description', 'like', $query);
        });
    }

    public function isActive(): bool
    {
        return $this->deleted_at == null;
    }
}
