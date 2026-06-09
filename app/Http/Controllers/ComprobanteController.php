<?php

namespace App\Http\Controllers;

use App\Models\Comprobante;
use Illuminate\Support\Facades\Auth;

class ComprobanteController extends Controller
{
    public function descargar(Comprobante $comprobante)
    {
        // Verificar que pertenece al cliente
        if ($comprobante->reserva->cliente_id !== Auth::guard('cliente')->id()) {
            abort(403);
        }

        return view('comprobantes.show', compact('comprobante'));
    }
}