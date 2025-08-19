<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            
            // Relación con users (correcta usando id estándar)
            $table->foreignId('user_id')
                  ->constrained() // users.id por defecto
                  ->onDelete('restrict');
            
            // Relación con membresías
            $table->foreignId('membership_id')
                  ->constrained('memberships')
                  ->onDelete('restrict');
            
            // Relación con status
            $table->foreignId('status_id')
                  ->constrained('statuses')
                  ->onDelete('restrict');
            
            $table->date('date');
            $table->decimal('price', 10, 2); // Campo obligatorio
            $table->string('receipt_url', 2048); // No nullable
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
