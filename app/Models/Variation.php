<?php

namespace App\Models;

use App\Console\Traits\HasFormattedPrice;
use App\Traits\HasImages;
use App\Traits\HasStock;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * @property mixed $id
 */
class Variation extends Model implements HasMedia
{
    use HasFactory;
    use HasRecursiveRelationships;
    use HasFormattedPrice;
    use InteractsWithMedia;
    use HasStock;
    use HasImages;

    protected $appends = [
        'display_name',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function stockCount()
    {
        return $this->stocks->sum('amount');
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

    /**
     * Get the formatted title.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::title($this->type),
        );
    }
}
