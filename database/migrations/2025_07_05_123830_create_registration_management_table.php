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
        Schema::create('registration_management', function (Blueprint $table) {
            $table->id(); // PK autoincremental

            // Claves foráneas
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('class_id');

            // Restricciones de clave foránea
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('class_id')
                  ->references('id')
                  ->on('classes')
                  ->onDelete('cascade');

            $table->timestamps();

            // Índice compuesto para evitar inscripciones duplicadas
            $table->unique(['user_id', 'class_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_management');
    }
};
