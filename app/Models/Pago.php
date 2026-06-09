<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';

    protected $fillable = [
        'reserva_id', 'mp_preference_id', 'mp_payment_id',
        'metodo', 'monto', 'estado',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }

    public function comprobante()
    {
        return $this->hasOne(Comprobante::class, 'pago_id');
    }

    public function estaAprobado(): bool
    {
        return $this->estado === 'aprobado';
    }
}
