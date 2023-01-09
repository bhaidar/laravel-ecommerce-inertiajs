<?php

namespace Database\Seeders;

use App\Models\ShippingType;
use Database\Factories\ShippingTypeFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShippingType::factory(2)->create();
    }
}
