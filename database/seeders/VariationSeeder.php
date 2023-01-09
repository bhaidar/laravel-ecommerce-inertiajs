<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Variation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $files = [
            'black' => './nike-air1-black.png',
            'white' => './nike-air1-white.png'
        ];

        Product::get()->each(function (Product $product) use ($files) {
            // Black variation
            Variation::factory(1)->create([
                'product_id' => $product->id,
                'title' => 'Black',
                'type' => 'color',
                'sku' => null,
                'parent_id' => null,
                'order' => 1
            ])->each(function (Variation $variation) use ($product, $files) {
                $variation->addMedia($files[array_rand($files)])
                    ->preservingOriginal()
                    ->toMediaCollection();

                // Size
                Variation::factory(1)->create([
                    'product_id' => $product->id,
                    'title' => '8',
                    'type' => 'size',
                    'sku' => null,
                    'parent_id' => $variation->id,
                    'order' => 1,
                ])->each(function (Variation $variation) use ($product, $files) {
                    $variation->addMedia($files[array_rand($files)])
                        ->preservingOriginal()
                        ->toMediaCollection();

                    // Season
                    Variation::factory(1)->create([
                        'product_id' => $product->id,
                        'title' => 'Summer',
                        'type' => 'season',
                        'sku' => 'abc'.rand(1, 100),
                        'parent_id' => $variation->id,
                        'order' => 1,
                    ])->each(function (Variation $variation) use ($files) {
                        $variation->addMedia($files[array_rand($files)])
                            ->preservingOriginal()
                            ->toMediaCollection();
                    });

                    Variation::factory(1)->create([
                        'product_id' => $product->id,
                        'title' => 'Winter',
                        'type' => 'season',
                        'sku' => 'abc'.rand(1, 100),
                        'parent_id' => $variation->id,
                        'order' => 2,
                    ])->each(function (Variation $variation) use ($files) {
                        $variation->addMedia($files[array_rand($files)])
                            ->preservingOriginal()
                            ->toMediaCollection();
                    });
                });

                // Size
                Variation::factory(1)->create([
                    'product_id' => $product->id,
                    'title' => '9',
                    'type' => 'size',
                    'sku' => null,
                    'parent_id' => $variation->id,
                    'order' => 2,
                ])->each(function (Variation $variation) use ($product, $files) {
                    $variation->addMedia($files[array_rand($files)])
                        ->preservingOriginal()
                        ->toMediaCollection();

                    // Season
                    Variation::factory(1)->create([
                        'product_id' => $product->id,
                        'title' => 'Summer',
                        'type' => 'season',
                        'sku' => 'abc'.rand(1, 100),
                        'parent_id' => $variation->id,
                        'order' => 1,
                    ])->each(function (Variation $variation) use ($files) {
                        $variation->addMedia($files[array_rand($files)])
                            ->preservingOriginal()
                            ->toMediaCollection();
                    });

                    Variation::factory(1)->create([
                        'product_id' => $product->id,
                        'title' => 'Winter',
                        'type' => 'season',
                        'sku' => 'abc'.rand(1, 100),
                        'parent_id' => $variation->id,
                        'order' => 2,
                    ])->each(function (Variation $variation) use ($files) {
                        $variation->addMedia($files[array_rand($files)])
                            ->preservingOriginal()
                            ->toMediaCollection();
                    });
                });
            });

            // White variation
            if ($product->id > 1) {
                Variation::factory(1)->create([
                    'product_id' => $product->id,
                    'title' => 'White',
                    'type' => 'color',
                    'sku' => null,
                    'parent_id' => null,
                    'order' => 1
                ])->each(function (Variation $variation) use ($product, $files) {
                    $variation->addMedia($files[array_rand($files)])
                        ->preservingOriginal()
                        ->toMediaCollection();

                    // Size
                    Variation::factory(1)->create([
                        'product_id' => $product->id,
                        'title' => '8',
                        'type' => 'size',
                        'sku' => null,
                        'parent_id' => $variation->id,
                        'order' => 1,
                    ])->each(function (Variation $variation) use ($product, $files) {
                        $variation->addMedia($files[array_rand($files)])
                            ->preservingOriginal()
                            ->toMediaCollection();

                        // Season
                        Variation::factory(1)->create([
                            'product_id' => $product->id,
                            'title' => 'Summer',
                            'type' => 'season',
                            'sku' => 'abc' . rand(1, 100),
                            'parent_id' => $variation->id,
                            'order' => 1,
                        ])->each(function (Variation $variation) use ($files) {
                            $variation->addMedia($files[array_rand($files)])
                                ->preservingOriginal()
                                ->toMediaCollection();
                        });

                        Variation::factory(1)->create([
                            'product_id' => $product->id,
                            'title' => 'Winter',
                            'type' => 'season',
                            'sku' => 'abc' . rand(1, 100),
                            'parent_id' => $variation->id,
                            'order' => 2,
                        ])->each(function (Variation $variation) use ($files) {
                            $variation->addMedia($files[array_rand($files)])
                                ->preservingOriginal()
                                ->toMediaCollection();
                        });
                    });

                    // Size
                    Variation::factory(1)->create([
                        'product_id' => $product->id,
                        'title' => '9',
                        'type' => 'size',
                        'sku' => null,
                        'parent_id' => $variation->id,
                        'order' => 2,
                    ])->each(function (Variation $variation) use ($product, $files) {
                        $variation->addMedia($files[array_rand($files)])
                            ->preservingOriginal()
                            ->toMediaCollection();

                        // Season
                        Variation::factory(1)->create([
                            'product_id' => $product->id,
                            'title' => 'Summer',
                            'type' => 'season',
                            'sku' => 'abc' . rand(1, 100),
                            'parent_id' => $variation->id,
                            'order' => 1,
                        ])->each(function (Variation $variation) use ($files) {
                            $variation->addMedia($files[array_rand($files)])
                                ->preservingOriginal()
                                ->toMediaCollection();
                        });

                        Variation::factory(1)->create([
                            'product_id' => $product->id,
                            'title' => 'Winter',
                            'type' => 'season',
                            'sku' => 'abc' . rand(1, 100),
                            'parent_id' => $variation->id,
                            'order' => 2,
                        ])->each(function (Variation $variation) use ($files) {
                            $variation->addMedia($files[array_rand($files)])
                                ->preservingOriginal()
                                ->toMediaCollection();
                        });
                    });
                });
            }
        });

        Variation::get()->each(function (Variation $variation) {
           $this->callWith(StockSeeder::class, ['variation' => $variation->id]);
        });
    }
}
