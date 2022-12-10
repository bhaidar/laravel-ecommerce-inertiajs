<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid'); // unique cart identifier that is stored inside the session
            $table->foreignId('user_id')->nullable()->constrained(); // Anonymous users can add items to cart
            $table->timestamps();
        });
    }
};
