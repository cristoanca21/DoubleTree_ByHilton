<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';

    protected $fillable = [
        'cliente_id', 'habitacion_id', 'fecha_ingreso', 'fecha_salida',
        'check_in_real', 'check_out_real', 'precio_noche_aplicado',
        'total', 'estado', 'motivo_cancelacion',
    ];

    protected $casts = [
        'fecha_ingreso' => 'datetime',
        'fecha_salida' => 'datetime',
        'check_in_real' => 'datetime',
        'check_out_real' => 'datetime',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class, 'habitacion_id');
    }

    public function pago()
    {
        return $this->hasOne(Pago::class, 'reserva_id');
    }

    public function comprobante()
    {
        return $this->hasOne(Comprobante::class, 'reserva_id');
    }
}
