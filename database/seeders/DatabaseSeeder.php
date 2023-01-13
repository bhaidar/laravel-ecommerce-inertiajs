<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ShippingAddress;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(VariationSeeder::class);
        $this->call(ShippingTypeSeeder::class);
        $this->callWith(ShippingAddressSeeder::class, ['user_id' => User::first()->id]);
    }
}
