<?php

namespace App\Models;

use App\Traits\MediaConversions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaraEditor\App\Contracts\Editable;
use LaraEditor\App\Traits\EditableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property Collection $media
 */
class Category extends Model implements HasMedia, Editable
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;
    use EditableTrait;
    use InteractsWithMedia;
    use MediaConversions {
        MediaConversions::registerMediaConversions insteadof InteractsWithMedia;
    }

    const FINE_JEWELRY_ID = 1;

    const HIGH_JEWELRY_ID = 2;

    const I_DO_BY_RAFKA_ID = 3;

    const OBJETS_ID = 4;

    const FINE_JEWELRY_RINGS_ID = 8;

    const FINE_JEWELRY_EARRINGS_ID = 9;

    const FINE_JEWELRY_BRACELET_ID = 10;

    const FINE_JEWELRY_NECKLACE_ID = 11;

    const FINE_JEWELRY_BROOCHES_ID = 12;

    const FINE_JEWELRY_PENDANTS_ID = 23;

    const HIGH_JEWELRY_RINGS_ID = 13;

    const HIGH_JEWELRY_EARRINGS_ID = 14;

    const HIGH_JEWELRY_BRACELET_ID = 15;

    const HIGH_JEWELRY_NECKLACE_ID = 16;

    const HIGH_JEWELRY_BROOCHES_ID = 17;

    const I_DO_BY_RAFKA_ENGAGEMENT_RINGS_ID = 18;

    const I_DO_BY_RAFKA_ETERNITY_BANDS_ID = 19;

    const I_DO_BY_RAFKA_STUD_EARRINGS_ID = 20;

    const I_DO_BY_RAFKA_RIVIERA_NECKLACES_ID = 21;

    const I_DO_BY_RAFKA_RIVIERA_BRACELETS_ID = 22;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public function scopeRoot(Builder $builder): Builder
    {
        return $builder->whereNull('parent_id');
    }

    public function scopeDefaultOrder(Builder $builder): Builder
    {
        return $builder->orderBy('sort_order', 'ASC');
    }

    public function scopePublished(Builder $builder): Builder
    {
        return $builder->where('is_published', true);
    }

    public function getEditorStoreUrl(): ?string
    {
        return route('admin.catalog.categories.editor.store', $this);
    }

    public function getEditorLoadUrl(): ?string
    {
        return route('admin.catalog.categories.editor.index', $this);
    }

    public function getEditorTemplatesUrl(): ?string
    {
        return route('admin.catalog.categories.editor.templates', $this);
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
                $query->where('name', 'LIKE', "%$part%");
            }
        });
    }

    /**
     * Get the category slides.
     */
    public function slides(): MorphMany
    {
        return $this->morphMany(Slide::class, 'slideable');
    }

    /**
     * Get the published category slides.
     */
    public function publishedSlides(): MorphMany
    {
        return $this->slides()->published();
    }

    public function subCategories(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order', 'ASC');
    }

    public function publishedChildren(): HasMany
    {
        return $this->children()->published();
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function publishedProducts(): BelongsToMany
    {
        return $this->products()->published()->latest();
    }

    public function setOrder(int $order): bool
    {
        return $this->update([
            'sort_order' => $order,
        ]);
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(100);
    }

    public function isPublished(): bool
    {
        return $this->is_published == 1;
    }
}
