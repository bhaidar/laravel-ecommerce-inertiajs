<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\Variation;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use stdClass;

class ShowProduct
{
    private const STOCK_COUNT = 'stockCount';
    private const IN_STOCK = 'inStock';
    private const OUT_OF_STOCK = 'outOfStock';
    private const LOW_STOCK = 'lowStock';
    private const CONFIG_MINIMUM_STOCK = 'services.shop.lowStock';

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
        $product = $this->calculateStock($product);

        // prepare media urls & return product
        return $this->loadMediaUrls($product);
    }

    private function calculateStock(Product $product): Product
    {
        if (!empty($product->variations))
        {
            foreach ($product->variations as $variation)
            {
                $variation[self::STOCK_COUNT] = $this->stockCount($variation);
                $product[self::STOCK_COUNT] += $variation[self::STOCK_COUNT];
            }

            $stockCount = intVal($product[self::STOCK_COUNT]);
            $product[self::IN_STOCK] =  $stockCount > 0;
            $product[self::OUT_OF_STOCK] = $stockCount <= 0;
            $product[self::LOW_STOCK] = !$product[self::OUT_OF_STOCK] && $stockCount < intVal(config(self::CONFIG_MINIMUM_STOCK));
        }

        return $product;
    }

    private function stockCount (Variation $variation): int
    {
        if (!empty($variation->stocks)) {
            $variation[self::STOCK_COUNT] = array_reduce($variation->stocks->toArray(), function ($carry, $item) {
                return $carry + $item['amount'];
            }, 0);
            $stockCount = intVal($variation[self::STOCK_COUNT]);
            $variation[self::IN_STOCK] =  $stockCount > 0;
            $variation[self::OUT_OF_STOCK] = $stockCount  <= 0;
            $variation[self::LOW_STOCK] = !$variation[self::OUT_OF_STOCK] && $stockCount < intVal(config(self::CONFIG_MINIMUM_STOCK));
        }

        if (!empty($variation->children)) {
            foreach ($variation->children as $childVariation)
            {
                $variation[self::STOCK_COUNT] += $this->stockCount($childVariation);
                $stockCount = intVal($variation[self::STOCK_COUNT]);

                $variation[self::IN_STOCK] = $stockCount > 0;
                $variation[self::OUT_OF_STOCK] = $stockCount <= 0;
                $variation[self::LOW_STOCK] = !$variation[self::OUT_OF_STOCK] && $stockCount < intVal(config(self::CONFIG_MINIMUM_STOCK));
            }
        }

        return $variation[self::STOCK_COUNT];
    }

    private function loadMediaUrls(Product $product): Product
    {
        $product->media = collect([]);

        // load product media
        Media::query()
            ->where('model_type', Product::class)
            ->where('model_id', $product->id)
            ->get()
            ->each(function ($media) use (&$product) {
                $product->media->push([
                    'original' => $media->getUrl(),
                    'conversions' => $this->getImageConversions($media),
                ]);
            });

        if ($product->media->count() === 0)
        {
            $product->media->push([
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