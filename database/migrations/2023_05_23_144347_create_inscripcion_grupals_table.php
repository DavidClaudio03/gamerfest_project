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
    Schema::create('inscripciones_grupales', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_equipo');
        $table->unsignedBigInteger('id_juego');
        $table->enum('estado', ['inscrito', 'asistido', 'cancelado']);
        $table->string('comprobante_pago')->nullable();
        $table->string('nro_comprobante')->nullable();
        $table->float('valor_comprobante')->nullable();
        $table->enum('estado_pago',['verificado','pendiente','cancelado'])->default('pendiente');
        $table->timestamps();

        $table->foreign('id_equipo')->references('id')->on('equipos')->onDelete('cascade');
        $table->foreign('id_juego')->references('id')->on('juegos')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripcion_grupals');
    }
};
