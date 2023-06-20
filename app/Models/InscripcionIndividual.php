<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscripcionIndividual extends Model
{
    use HasFactory;

    protected $table = 'inscripciones_individuales';
    
    protected $fillable = [
        'user_id',
        'id_juego',
        'estado',
        'comprobante_pago',
        'nro_comprobante',
        'valor_comprobante',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function juego()
    {
        return $this->belongsTo(Juego::class, 'id_juego');
    }
}
