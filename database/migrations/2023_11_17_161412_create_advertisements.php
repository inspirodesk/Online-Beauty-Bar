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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date'); 
            $table->string('author');
            $table->string('content'); 
            $table->string('image_url')->nullable(); 
            $table->string('category'); 
            $table->boolean('ispopup')->nullable();
            $table->boolean('isclosepopup')->nullable();
            $table->string('display_time')->nullable(); 
            $table->string('email'); 
            $table->string('mobile'); 
            $table->string('address'); 
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
