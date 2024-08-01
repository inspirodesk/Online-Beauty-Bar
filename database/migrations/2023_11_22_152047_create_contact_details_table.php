<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('contact_details', function (Blueprint $table) {
            $table->id();
            $table->string('object_id');
            $table->string('contact_name');
            $table->string('contact_number');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contact_details');
    }
}
