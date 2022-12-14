<?php

namespace App\Models;

use App\Console\Traits\HasFormattedPrice;
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
 */
class Product extends Model implements HasMedia
{
    use HasFactory;
    use HasFormattedPrice;
    use InteractsWithMedia;
    use HasStock;
    use HasImages;

    public function loadVariationTree()
    {
        $this->setRelation(
            'variations',
            Variation::with(['stocks'])
                ->treeOf(fn($query) => $query->isRoot()->where('product_id', $this->id))
                ->get()
                ->toTree()
        );
    }

    public function loadStock(): void
    {
        if (!$this->variations)
        {
            $this->loadVariationTree();
        }

        foreach ($this->variations as $variation) {
            $this->getStock($variation);
        }
    }

    public function loadImages()
    {
        $this->getImages();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb200x200')
            ->fit(Manipulations::FIT_CROP, 200, 200);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('default')
            ->useFallbackUrl(url('/images/no_image_available.jpg'));
    }
}
