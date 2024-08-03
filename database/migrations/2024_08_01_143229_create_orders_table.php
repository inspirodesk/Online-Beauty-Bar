<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('woocommerce_id')->unique();
            $table->string('status');
            $table->decimal('total', 10, 2);
            $table->string('shipping_first_name');
            $table->string('shipping_last_name');
            $table->string('shipping_company');
            $table->string('shipping_address_1');
            $table->string('shipping_address_2');
            $table->string('shipping_city');
            $table->string('shipping_state');
            $table->string('shipping_postcode');
            $table->string('shipping_country');
            $table->string('shipping_email');
            $table->string('shipping_phone');
            $table->string('payment_method_title');

            // Product fields
            $table->string('name');
            $table->string('permalink')->nullable();;
            $table->string('number');
            $table->timestamp('created_via');

            $table->json('line_items');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
