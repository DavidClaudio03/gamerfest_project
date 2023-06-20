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
        Schema::create('juegos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',50);
            $table->string('genero',50);
            $table->decimal('costo_inscripcion', 10, 2);
            $table->date('fecha_limite_inscripcion');
            $table->enum('modalidad', ['individual', 'grupo']);
            $table->string('img_id',20)->default('sample_img');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('juegos');
    }
};
