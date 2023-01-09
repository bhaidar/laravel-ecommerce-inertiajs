<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($categoryId): void
    {
        $category = Category::query()->find($categoryId);

        $files = [
            'black' => './nike-air1-black.png',
            'white' => './nike-air1-white.png'
        ];

        Product::factory(2)->create()->each(function (Product $product) use ($files, $category) {
            $product->addMedia($files[array_rand($files)])
                ->preservingOriginal()
                ->toMediaCollection();

            $category->products()->attach($product);
        });
    }
}
