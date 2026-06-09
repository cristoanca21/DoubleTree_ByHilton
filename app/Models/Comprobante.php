<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    protected $table = 'comprobantes';

    protected $fillable = [
        'pago_id', 'reserva_id', 'numero_boleta',
        'pdf_path', 'estado', 'emitido_at',
    ];

    protected $casts = ['emitido_at' => 'datetime'];

    public function pago()
    {
        return $this->belongsTo(Pago::class, 'pago_id');
    }

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }
}
