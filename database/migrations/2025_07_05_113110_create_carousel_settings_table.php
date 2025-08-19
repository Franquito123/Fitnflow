<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarouselSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('carousel_settings', function (Blueprint $table) {
            $table->id();
            $table->string('style')->default('ring'); // ring, flat, star
            $table->integer('radius')->default(300);  // distancia en px
            $table->integer('duration')->default(20); // duración en segundos
            $table->boolean('brightness_animation')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carousel_settings');
    }
}