<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('names', 255);
            $table->string('last_name', 255);
            $table->date('birth_date');
            $table->string('gender', 255);
            $table->string('email', 255)->unique();

                // Relación con roles
            $table->unsignedBigInteger('rol_id')->default(2);
            $table->foreign('rol_id')
                ->references('id')
                ->on('roles')
                ->onDelete('restrict');
            
            // Estado del usuario
            $table->unsignedBigInteger('status_id')->default(1);
            $table->foreign('status_id')
                ->references('id')
                ->on('statuses')
                ->onDelete('restrict');

            $table->string('password', 255);
            $table->string('specialty', 255)->nullable();
            $table->string('certification', 255)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};
