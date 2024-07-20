<?php

namespace App\Models;

use App\Contracts\Ownable;
use App\Models\Admin\Staff;
use App\Traits\MediaConversions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
class Blog extends Model implements Editable, HasMedia, Ownable
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;
    use EditableTrait;
    use InteractsWithMedia;
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
        'published_at' => 'date:Y-m-d',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'author_id');
    }

    public function getEditorStoreUrl(): ?string
    {
        return route('admin.cms.blogs.editor.store', $this);
    }

    public function getEditorLoadUrl(): ?string
    {
        return route('admin.cms.blogs.editor.index', $this);
    }

    public function getEditorTemplatesUrl(): ?string
    {
        return route('admin.cms.blogs.editor.templates', $this);
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(100);
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

    public function publishedDate(): Attribute
    {
        return Attribute::make(
            fn ($value) => $this->published_at->format('M d, Y')
        );
    }

    /**
     * Get short title with a limit of 50 characters
     *
     * @return string
     */
    public function getShortTitleAttribute()
    {
        return Str::limit($this->title, 50, ' ...');
    }

    public function isOwnedBy(Authenticatable $author): bool
    {
        return $this->author_id == $author->getAuthIdentifier();
    }

    public function isPublished(): bool
    {
        return $this->is_published == 1;
    }
}
