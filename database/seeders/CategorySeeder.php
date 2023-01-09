<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $brand = Category::factory(1)->create([
            'title' => 'Brands',
            'slug' => Str::slug('Brands'),
            'parent_id' => null,
        ])->each(function (Category $category) {
            $this->callWith(ProductSeeder::class, ['categoryId' => $category->id]);
        })->first();

        $nike = Category::factory(1)->create([
            'title' => 'Nike',
            'slug' => Str::slug('Nike'),
            'parent_id' => $brand->id,
        ])->each(function (Category $category) {
            $this->callWith(ProductSeeder::class, ['categoryId' => $category->id]);
        })->first();

        Category::factory(1)->create([
            'title' => 'Shoes',
            'slug' => Str::slug('Shoes'),
            'parent_id' => $nike->id,
        ])->each(function (Category $category) {
            $this->callWith(ProductSeeder::class, ['categoryId' => $category->id]);
        });

        $seasons = Category::factory(1)->create([
            'title' => 'Seasons',
            'slug' => Str::slug('Seasons'),
            'parent_id' => null,
        ])->each(function (Category $category) {
            $this->callWith(ProductSeeder::class, ['categoryId' => $category->id]);
        })->first();

        Category::factory(1)->create([
            'title' => 'Summer',
            'slug' => Str::slug('Summer'),
            'parent_id' => $seasons->id,
        ])->each(function (Category $category) {
            $this->callWith(ProductSeeder::class, ['categoryId' => $category->id]);
        });

        Category::factory(1)->create([
            'title' => 'Winter',
            'slug' => Str::slug('Winter'),
            'parent_id' => $seasons->id,
        ])->each(function (Category $category) {
            $this->callWith(ProductSeeder::class, ['categoryId' => $category->id]);
        });
    }
}
