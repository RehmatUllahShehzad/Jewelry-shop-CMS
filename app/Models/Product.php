<?php

namespace App\Models;

use App\Contracts\Ownable;
use App\Models\Admin\Staff;
use App\Traits\MediaConversions;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property string|null $bannerImageUrl
 * @property-read Collection $media
 */
class Product extends Model implements HasMedia, Ownable
{
    use HasFactory,
        HasSlug,
        SoftDeletes,
        InteractsWithMedia,
        MediaConversions {
            MediaConversions::registerMediaConversions insteadof InteractsWithMedia;
        }

    public function scopeOfStaff(Builder $builder, Staff $staff): Builder
    {
        return $builder->where('staff_id', $staff->id);
    }

    public function scopePublished(Builder $builder, bool $is_published = true): Builder
    {
        return $builder->where('is_published', $is_published);
    }

    /**
     * Apply the basic search scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $term
     * @return void
     */
    public function scopeSearch($query, $term)
    {
        if (! $term) {
            return;
        }

        $query->where(function ($query) use ($term) {
            $parts = array_map('trim', explode(' ', $term));
            foreach ($parts as $part) {
                $query->where('title', 'LIKE', "%$part%")
                    ->orWhere('slug', 'LIKE', "%$part%");
            }
        });
    }

    /**
     * Apply the basic date range scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $range
     * @return void
     */
    public function scopeDateFilter($query, $range)
    {
        if (empty($range)) {
            return;
        }

        if (isset($range[0])) {
            $query->whereDate('created_at', '>=', (new Carbon($range[0]))->format('Y-m-d'));
        }

        if (isset($range[1]) && $range[1] != '...') {
            $query->whereDate('created_at', '<=', (new Carbon($range[1]))->format('Y-m-d'));
        }
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function isOwnedBy(Authenticatable $staff): bool
    {
        return $this->staff_id == $staff->getAuthIdentifier();
    }

    public function bannerImageUrl(): Attribute
    {
        return Attribute::make(
            fn ($value) => $this->getFirstMediaUrl('banner', conversionName: 'thumb')
        );
    }

    public function galleryImages(): Attribute
    {
        return Attribute::make(
            fn ($value) => $this->getMedia(self::class)
                ->sortByDesc('custom_properties.primary')
                ->map(function ($media) {
                    /** @var Media $media */
                    return $media->getUrl();
                })
        );
    }

    public function galleryImageThumbnails(): Attribute
    {
        return Attribute::make(
            fn ($value) => $this->getMedia(self::class)
                ->sortByDesc('custom_properties.primary')
                ->map(function ($media) {
                    /** @var Media $media */
                    return $media->getAvailableUrl(['medium']);
                })
        );
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
