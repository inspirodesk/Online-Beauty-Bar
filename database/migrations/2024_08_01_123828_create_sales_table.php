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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('cus_id');
            $table->string('customer_name');
            $table->string('address');
            $table->string('contact_number');
            $table->string('whatsapp_number')->nullable();
            $table->string('order_no');
            $table->string('track_no');
            $table->string('payment_method');
            $table->string('status');
            $table->string('delivery_status')->nullable();
            $table->decimal('discount', 8, 2)->nullable();
            $table->decimal('subtotal', 8, 2)->default(0);
            $table->decimal('final_total', 8, 2)->default(0);
            $table->string('attachment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
