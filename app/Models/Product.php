<?php

namespace App\Models;

use App\Console\Traits\HasFormattedPrice;
use App\Http\Resources\ProductResource;
use App\Traits\HasImages;
use App\Traits\HasStock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    protected const CONVERSION_NAME = 'thumb200x200';

    public function loadStock(): void
    {
        // Assuming variations are loaded
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
            ->useFallbackUrl(url('/images/no_image_available.jpg'));
    }

    public function toResource(): ProductResource
    {
        return new ProductResource($this);
    }
}
