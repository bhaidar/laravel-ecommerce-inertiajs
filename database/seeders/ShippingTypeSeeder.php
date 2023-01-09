<?php

namespace Database\Seeders;

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
        ShippingTypeFactory::factory(2)->create();
    }
}
