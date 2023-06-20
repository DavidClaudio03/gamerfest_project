<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'genero',
        'costo_inscripcion',
        'fecha_limite_inscripcion',
        'modalidad',
        'img_id'
    ];

    // En Juego.php
    public function inscripcionesIndividuales()
    {
        return $this->hasMany(InscripcionIndividual::class, 'id_juego');
    }

    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'id_juego');
    }

    public function inscripcionesGrupales()
    {
        return $this->hasMany(InscripcionGrupal::class, 'id_juego');
    }

    public function ganadoresIndividuales()
    {
        return $this->hasMany(GanadorIndividual::class, 'id_juego');
    }

    public function ganadoresGrupales()
    {
        return $this->hasMany(GanadorGrupal::class, 'id_juego');
    }

}
