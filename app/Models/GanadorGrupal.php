<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GanadorGrupal extends Model
{
    use HasFactory;
    
    protected $table = 'ganadores_grupales';

    protected $fillable = [
        'id_juego',
        'id_equipo',
        'posicion',
    ];

    public function juego()
    {
        return $this->belongsTo(Juego::class, 'id_juego');
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo');
    }
}
