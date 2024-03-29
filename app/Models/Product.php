<?php

namespace App\Models;

use App\Http\Resources\ProductResource;
use App\Models\Scopes\LiveScope;
use App\Traits\HasFormattedPrice;
use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property mixed $id
 * @property mixed $thumbnails
 */
class Product extends Model implements HasMedia
{
    use HasFactory;
    use HasFormattedPrice;
    use InteractsWithMedia;
    use HasImages;
    use Searchable;

    protected const CONVERSION_NAME = 'thumb200x200';

    public static function booted()
    {
        static::addGlobalScope(new LiveScope());
    }

    protected function getMoneyAttribute(): string
    {
        return 'price';
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function variations(): HasMany
    {
        return $this->HasMany(Variation::class);
    }

    public function loadStock(): void
    {
        if (!$this->relationLoaded('variations'))
        {
            return;
        }

        foreach ($this->variations as $variation) {
            $variation->loadStock();
        }
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion(self::CONVERSION_NAME)
            ->fit(Manipulations::FIT_CROP, 200, 200);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('default')
            ->useFallbackUrl(url('/images/no_image_available.png'));
    }

    /**
     * Decide which fields appear on meilisearch
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        return array_merge(
            [
                'id' => $this->id,
                'title' => $this->title,
                'slug' => $this->slug,
                'description' => $this->description,
                'price' => intVal($this->price->getAmount()),
                'category_ids' => $this->categories->pluck('id'),
            ],
            $this->variations->groupBy('type')
            ->mapWithKeys(fn ($variations, $key) => [ $key => $variations->pluck('title')])
            ->toArray(),
        );
    }
    public static function getSearchFilterAttributes(): array
    {
        return [
            'category_ids',
            'size',
            'color',
            'price',
            'season',
        ];
    }

    public function toResource(): ProductResource
    {
        return new ProductResource($this);
    }
}
