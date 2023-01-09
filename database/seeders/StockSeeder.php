<?php

namespace Database\Seeders;

use App\Models\Stock;
use Database\Factories\StockFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($variation): void
    {
        Stock::factory(1)->create([
            'variation_id' => $variation,
        ]);
    }
}
