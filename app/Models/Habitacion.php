<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    protected $table = 'habitaciones';

    protected $fillable = ['tipo_id', 'numero', 'piso', 'estado'];

    public function tipo()
    {
        return $this->belongsTo(TipoHabitacion::class, 'tipo_id');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'habitacion_id');
    }

    public function estaDisponible(): bool
    {
        return $this->estado === 'disponible';
    }
}
