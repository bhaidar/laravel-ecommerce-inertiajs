<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\Variation;
use App\Traits\HasStock;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ShowProduct
{
    use HasStock;

    public function execute(Product $product): Product
    {
        // set dynamic relation
        $product->setRelation(
            'variations',
            Variation::with(['stocks'])
                ->treeOf(fn($query) => $query->isRoot()->where('product_id', $product->id))
                ->get()
                ->toTree()
        );

        // calculate stock at each level
        $product->includeStock();

        // prepare media urls & return product
        return $this->loadMediaUrls($product);
    }

    private function loadMediaUrls(Product $product): Product
    {
        // I've chosen to use images not media in order not to have
        // any conflicts with spatie media library package
        $product->images = collect([]);

        // load product media
        Media::query()
            ->where('model_type', Product::class)
            ->where('model_id', $product->id)
            ->get()
            ->each(function ($media) use (&$product) {
                $product->images->push([
                    'original' => $media->getUrl(),
                    'conversions' => $this->getImageConversions($media),
                ]);
            });

        // Set the default image when no other images are stored in the db
        if ($product->images->count() === 0)
        {
            $product->images->push([
                'original' => $product->getFirstMediaUrl()
            ]);
        }

        return $product;
    }

    private function getImageConversions(Media $media): array
    {
        $conversions = [];

        foreach ($media->generated_conversions as $conversion => $key) {
            $conversions[] = $media->getUrl($conversion);
        }

        return $conversions;
    }
}