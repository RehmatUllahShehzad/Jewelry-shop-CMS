<?php

namespace App\Models;

use App\Traits\MediaConversions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property-read Collection $media
 * @property-read ?Media $secondaryImage
 */
class Slide extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;
    use MediaConversions {
        MediaConversions::registerMediaConversions insteadof InteractsWithMedia;
    }

    protected $guarded = [];

    public function scopePublished(Builder $builder, bool $is_published = true): Builder
    {
        return $builder->where('is_published', $is_published);
    }

    public function slideable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getSecondaryImageUrl(string $conversionName = 'medium'): string | null
    {
        return $this->secondaryImage?->getAvailableUrl([$conversionName]);
    }

    /**
     * Relationship for secondaryImage.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function secondaryImage(): MorphOne
    {
        return $this->morphOne(config('media-library.media_model'), 'model')
            ->where('custom_properties->primary', false);
    }

    public function scopeSearch(Builder $builder, string $query): Builder
    {
        return $builder->where(function (Builder $builder) use ($query) {
            $query = "%{$query}%";

            $builder->where('title', 'like', $query);
            $builder->orWhere('sub_title', 'like', $query);
            $builder->orWhere('description', 'like', $query);
        });
    }
}
