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
    Schema::create('carousel_slides', function (Blueprint $table) {
        $table->id();
        $table->text('description')->nullable();
        $table->string('image_path'); // guarda solo el path o nombre del archivo
        $table->string('link_url')->nullable();
        $table->integer('display_order')->default(0);
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carousel_slides');
    }
};