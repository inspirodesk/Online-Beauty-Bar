<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('news_site', function (Blueprint $table) {
            $table->foreignId('news_id')->constrained();
            $table->foreignId('site_id')->constrained();
            $table->timestamps(); // You can include timestamps if needed
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('news_site');
    }
};
