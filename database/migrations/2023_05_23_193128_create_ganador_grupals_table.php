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
        Schema::create('ganadores_grupales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_juego');
            $table->unsignedBigInteger('id_equipo');
            $table->integer('posicion');
            $table->timestamps();

            $table->foreign('id_juego')->references('id')->on('juegos');
            $table->foreign('id_equipo')->references('id')->on('equipos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ganadores_grupales');
    }
};
