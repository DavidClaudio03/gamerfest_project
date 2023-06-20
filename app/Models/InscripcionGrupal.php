<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscripcionGrupal extends Model
{
    use HasFactory;
    
    protected $table = 'inscripciones_grupales';
    
    protected $fillable = [
        'id_equipo',
        'id_juego',
        'estado',
        'comprobante_pago',
        'nro_comprobante',
        'valor_comprobante',
    ];

    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo');
    }

    public function juego()
    {
        return $this->belongsTo(Juego::class, 'id_juego');
    }
}
