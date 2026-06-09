<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoHabitacion extends Model
{
    protected $table = 'tipo_habitacion';

    protected $fillable = [
        'nombre', 'descripcion', 'precio_noche', 'capacidad', 'imagen',
    ];

    public function habitaciones()
    {
        return $this->hasMany(Habitacion::class, 'tipo_id');
    }
}
