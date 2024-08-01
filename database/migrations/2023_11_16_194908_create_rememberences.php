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
    Schema::create('rememberences', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->date('dateOfDeath');
        $table->string('frame_image_url')->nullable();
        $table->string('normal_image_url')->nullable();
        $table->string('address');  
        $table->date('rememberanceDay'); 
        $table->string('startTime'); 
        $table->string('endTime'); 
        $table->string('furtherAnnouncement'); 
        $table->string('contactId')->nullable();
        $table->date('adStartDate'); 
        $table->date('adEndDate'); 
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rememberences');
    }
};
