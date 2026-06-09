@extends('layouts.app')
@section('title', 'Procesar Pago')

@section('content')
<div class="max-w-xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-xl p-8">

        <div class="text-center mb-8">
            <div class="bg-doubletree-navy rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <i class="fa fa-credit-card text-2xl doubletree-gold"></i>
            </div>
            <h1 class="text-2xl font-bold text-doubletree-navy">Procesar Pago</h1>
            <p class="text-gray-500 text-sm mt-1">Reserva #{{ $reserva->id }}</p>
        </div>

        {{-- Resumen --}}
        <div class="bg-gray-50 rounded-xl p-5 mb-6 space-y-3">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Habitación</span>
                <span class="font-medium text-doubletree-navy">
                    {{ $reserva->habitacion->numero }} — {{ $reserva->habitacion->tipo->nombre }}
                </span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Ingreso</span>
                <span class="font-medium">
                    {{ \Carbon\Carbon::parse($reserva->fecha_ingreso)->format('d/m/Y H:i') }}
                </span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Salida</span>
                <span class="font-medium">
                    {{ \Carbon\Carbon::parse($reserva->fecha_salida)->format('d/m/Y H:i') }}
                </span>
            </div>
            <div class="border-t pt-3 flex justify-between">
                <span class="font-bold text-doubletree-navy">Total a pagar</span>
                <span class="font-bold text-xl text-doubletree-navy">
                    S/ {{ number_format($reserva->total, 2) }}
                </span>
            </div>
        </div>

        {{-- Botón MercadoPago (simulado) --}}
        <div class="space-y-3">
            <a href="{{ route('pagos.exitoso', ['external_reference' => $reserva->id]) }}"
               class="w-full bg-blue-500 text-white py-3 rounded-xl font-bold text-center block hover:bg-blue-600 transition">
                <i class="fa fa-lock mr-2"></i>Pagar con MercadoPago
            </a>
            <a href="{{ route('pagos.fallido') }}"
               class="w-full bg-gray-100 text-gray-600 py-3 rounded-xl text-sm text-center block hover:bg-gray-200 transition">
                Simular pago fallido
            </a>
        </div>

        <p class="text-center text-xs text-gray-400 mt-4">
            <i class="fa fa-shield-halved mr-1"></i>
            Pago seguro procesado por MercadoPago
        </p>
    </div>
</div>
@endsection