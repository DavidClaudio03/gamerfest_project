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
        Schema::create('ganadores_individuales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_juego');
            $table->unsignedBigInteger('user_id');
            $table->integer('posicion');
            $table->timestamps();

            $table->foreign('id_juego')->references('id')->on('juegos');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ganadores_individuales');
    }
};
