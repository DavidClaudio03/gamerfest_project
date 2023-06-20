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
        Schema::create('inscripciones_individuales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Cambiado a id_participante
            $table->unsignedBigInteger('id_juego');
            $table->enum('estado', ['inscrito', 'asistido', 'cancelado']);
            $table->string('comprobante_pago')->nullable();
            $table->string('nro_comprobante')->nullable();
            $table->float('valor_comprobante')->nullable();
            $table->enum('estado_pago',['verificado','pendiente','cancelado'])->default('pendiente');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users'); // referenciado a la tabla participantes
            $table->foreign('id_juego')->references('id')->on('juegos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripciones_individuales');
    }
};
