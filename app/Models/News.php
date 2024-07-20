<?php

namespace App\Models;

use App\Contracts\Ownable;
use App\Models\Admin\Staff;
use App\Traits\MediaConversions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use LaraEditor\App\Contracts\Editable;
use LaraEditor\App\Traits\EditableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property-read Collection $media
 */
class News extends Model implements HasMedia, Ownable, Editable
{
    use HasFactory,
        HasSlug,
        SoftDeletes,
        EditableTrait,
        InteractsWithMedia;
    use MediaConversions {
        MediaConversions::registerMediaConversions insteadof InteractsWithMedia;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * @var array<int, string>
     */
    protected $appends = ['short_title'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'author_id');
    }

    public function getEditorStoreUrl(): ?string
    {
        return route('admin.cms.news.editor.store', $this);
    }

    public function getEditorLoadUrl(): ?string
    {
        return route('admin.cms.news.editor.index', $this);
    }

    public function getEditorTemplatesUrl(): ?string
    {
        return route('admin.cms.news.editor.templates', $this);
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

    public function isOwnedBy(Authenticatable $author): bool
    {
        return $this->author_id == $author->getAuthIdentifier();
    }

    public function isPublished(): bool
    {
        return $this->is_published == 1;
    }

    /**
     * Get short title with a limit of 35 characters
     *
     * @return string
     */
    public function getShortTitleAttribute()
    {
        return Str::limit($this->title, 35, ' ...');
    }
}
