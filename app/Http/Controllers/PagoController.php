<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Pago;
use App\Models\Comprobante;
use Illuminate\Support\Facades\Log;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;

class PagoController extends Controller
{
    public function __construct()
    {
        MercadoPagoConfig::setAccessToken(env('MP_ACCESS_TOKEN'));
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);
    }

    public function iniciar(Reserva $reserva)
    {
        if ($reserva->cliente_id !== auth('cliente')->id()) {
            abort(403);
        }

        // Limpiar pago anterior para generar preferencia nueva
        if ($reserva->pago && $reserva->pago->mp_preference_id) {
            $reserva->pago->delete();
        }

        try {
            $client = new PreferenceClient();

            $preference = $client->create([
                'items' => [[
                    'id'          => 'HAB-' . $reserva->habitacion->numero,
                    'title'       => 'Reserva — ' . $reserva->habitacion->tipo->nombre . ' Nº ' . $reserva->habitacion->numero,
                    'description' => 'Check-in: ' . $reserva->fecha_ingreso . ' | Check-out: ' . $reserva->fecha_salida,
                    'quantity'    => 1,
                    'unit_price'  => (float) $reserva->total,
                    'currency_id' => 'PEN',
                ]],
                'payer' => [
                    'name'    => $reserva->cliente->nombre,
                    'surname' => $reserva->cliente->apellido,
                    'email'   => $reserva->cliente->email,
                ],
                'external_reference'   => (string) $reserva->id,
                'back_urls'            => [
                    'success' => route('pagos.exitoso'),
                    'failure' => route('pagos.fallido'),
                    'pending' => route('pagos.fallido'),
                ],
                'auto_approve'         => true,
                'notification_url'     => 'https://doubletree-byhilton-main-3n0mhs.laravel.cloud/webhook/mp',
                'statement_descriptor' => 'DoubleTree Trujillo',
                'expires'              => false,
            ]);

            Pago::create([
                'reserva_id'       => $reserva->id,
                'mp_preference_id' => $preference->id,
                'monto'            => $reserva->total,
                'estado'           => 'pendiente',
                'metodo'           => 'mercadopago',
            ]);

            return redirect($preference->init_point);

        } catch (\Exception $e) {
            Log::error('MercadoPago error: ' . $e->getMessage());
            return redirect()->route('reservas.show', $reserva)
                ->withErrors(['error' => 'Error al conectar con MercadoPago. Intenta nuevamente.']);
        }
    }
    public function webhook(Request $request)
{
    Log::info('=== WEBHOOK MP RECIBIDO ===', $request->all());

    $tipo      = $request->input('type') ?? $request->input('topic');
    $paymentId = $request->input('data.id') ?? $request->input('id');

    Log::info("Tipo: {$tipo} | PaymentId: {$paymentId}");

    // Manejar merchant_order
    if ($tipo === 'merchant_order') {
        try {
            MercadoPagoConfig::setAccessToken(env('MP_ACCESS_TOKEN'));
            
            // Obtener la orden para encontrar el payment_id
            $resource = $request->input('resource');
            $orderId  = $paymentId;
            
            Log::info('Procesando merchant_order: ' . $orderId);
            
            // Buscar por external_reference en la URL del resource
            // El external_reference está en la preferencia
            // Intentar obtener pagos de la orden
            $client   = new \MercadoPago\Client\MerchantOrder\MerchantOrderClient();
            $order    = $client->get((int) $orderId);
            $orderData = json_decode(json_encode($order), true);
            
            Log::info('Order data:', $orderData);
            
            $externalRef = $orderData['external_reference'] ?? null;
            $payments    = $orderData['payments'] ?? [];
            
            $pagoAprobado = false;
            $mpPaymentId  = null;
            
            foreach ($payments as $payment) {
                if ($payment['status'] === 'approved') {
                    $pagoAprobado = true;
                    $mpPaymentId  = $payment['id'];
                    break;
                }
            }
            
            if ($pagoAprobado && $externalRef) {
                $reserva = Reserva::find($externalRef);
                $pago    = $reserva?->pago;
                
                if ($pago) {
                    $pago->update([
                        'mp_payment_id' => $mpPaymentId,
                        'estado'        => 'aprobado',
                    ]);
                    $reserva->update(['estado' => 'confirmada']);
                    $this->generarComprobante($pago);
                    Log::info('✅ Reserva confirmada via merchant_order');
                }
            }
            
        } catch (\Exception $e) {
            Log::error('merchant_order error: ' . $e->getMessage());
        }
        
        return response()->json(['ok' => true]);
    }

    if ($tipo !== 'payment' || !$paymentId) {
        Log::info('Webhook ignorado');
        return response()->json(['ok' => true]);
    }

    try {
        MercadoPagoConfig::setAccessToken(env('MP_ACCESS_TOKEN'));
        $client  = new PaymentClient();
        $payment = $client->get((int) $paymentId);

        $paymentData  = json_decode(json_encode($payment), true);
        $preferenceId = $paymentData['preference_id'] ?? null;
        $status       = $paymentData['status'] ?? 'rejected';
        $externalRef  = $paymentData['external_reference'] ?? null;

        Log::info('Payment data:', [
            'status'        => $status,
            'preference_id' => $preferenceId,
            'external_ref'  => $externalRef,
        ]);

        $pago = $preferenceId
            ? Pago::where('mp_preference_id', $preferenceId)->first()
            : null;

        if (!$pago && $externalRef) {
            $reserva = Reserva::find($externalRef);
            $pago    = $reserva?->pago;
        }

        if (!$pago) {
            Log::warning('Pago no encontrado.');
            return response()->json(['ok' => true]);
        }

        $estadoPago = match($status) {
            'approved' => 'aprobado',
            'rejected' => 'rechazado',
            default    => 'pendiente',
        };

        $pago->update([
            'mp_payment_id' => $paymentId,
            'estado'        => $estadoPago,
        ]);

        if ($estadoPago === 'aprobado') {
            $pago->reserva->update(['estado' => 'confirmada']);
            $this->generarComprobante($pago);
            Log::info('✅ Reserva confirmada');
        } elseif ($estadoPago === 'rechazado') {
            $pago->reserva->update(['estado' => 'pendiente']);
            Log::info('❌ Pago rechazado');
        }

    } catch (\Exception $e) {
        Log::error('Webhook MP error: ' . $e->getMessage());
    }

    return response()->json(['ok' => true]);
}

    public function exitoso(Request $request)
    {
        $reservaId = $request->input('external_reference');

        if (!$reservaId) {
            return redirect()->route('reservas.index')
                ->with('info', 'Pago procesado. Verificando estado...');
        }

        $reserva = Reserva::with(['comprobante', 'habitacion.tipo', 'pago'])
                    ->findOrFail($reservaId);

        return view('pagos.exitoso', compact('reserva'));
    }

    public function fallido(Request $request)
    {
        $reservaId = $request->input('external_reference');
        $reserva   = $reservaId ? Reserva::find($reservaId) : null;
        return view('pagos.fallido', compact('reserva'));
    }

    private function generarComprobante(Pago $pago): void
    {
        if (Comprobante::where('pago_id', $pago->id)->exists()) {
            return;
        }

        $anio   = now()->format('Y');
        $ultimo = Comprobante::whereYear('created_at', $anio)->count();
        $numero = 'BOL-' . $anio . '-' . str_pad($ultimo + 1, 4, '0', STR_PAD_LEFT);

        Comprobante::create([
            'pago_id'       => $pago->id,
            'reserva_id'    => $pago->reserva_id,
            'numero_boleta' => $numero,
            'estado'        => 'emitido',
            'emitido_at'    => now(),
        ]);
    }
}