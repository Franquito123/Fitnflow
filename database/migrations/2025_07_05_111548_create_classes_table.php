<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services');
            $table->foreignId('status_id')->constrained('statuses');
            $table->foreignId('instructor_id')->constrained('users');
            $table->date('date');
            $table->time('time');
            $table->text('description');
            $table->integer('max_capacity');
            $table->string('room', 50);
            $table->text('comment')->nullable();
            $table->boolean('notification')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('classes');
    }
};