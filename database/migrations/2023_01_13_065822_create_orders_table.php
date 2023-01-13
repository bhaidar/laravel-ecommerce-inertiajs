<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid'); // a unique order number
            $table->string('email'); // user who is checking out
            $table->foreignId('user_id')->nullable()->constrained(); // a non-logged in user can create orders
            $table->foreignId('shipping_address_id')->constrained();
            $table->foreignId('shipping_type_id')->constrained();
            $table->integer('subtotal');
            $table->timestamp('placed_at');
            $table->timestamp('packaged_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
