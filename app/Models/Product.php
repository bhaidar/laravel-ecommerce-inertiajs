<?php

namespace App\Models;

use App\Console\Traits\HasFormattedPrice;
use App\Http\Resources\ProductResource;
use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
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
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'category_ids' => $this->categories->pluck('id'),
        ];
    }
    public static function getSearchFilterAttributes(): array
    {
        return [
            'category_ids',
        ];
    }

    public function toResource(): ProductResource
    {
        return new ProductResource($this);
    }
}
