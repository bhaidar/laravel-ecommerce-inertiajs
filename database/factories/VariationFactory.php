<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Variation>
 */
class VariationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => '',
            'title' => '',
            'price' => $this->faker->numberBetween(10000, 40000),
            'type' => '',
            'sku' => '',
            'parent_id' => '',
            'order' => 0,
        ];
    }
}
