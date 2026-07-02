@extends('layouts.app')
@section('title', 'Comprobante ' . $comprobante->numero_boleta)

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

        {{-- Encabezado --}}
        <div class="bg-doubletree-navy px-8 py-6 flex items-center justify-between">
            <div>
                <h1 class="text-black font-bold text-xl">Comprobante de Pago</h1>
                <p class="text-gray-300 text-sm mt-1">{{ $comprobante->numero_boleta }}</p>
            </div>
            <div class="text-right">
                <span class="bg-green-400 text-white text-xs font-bold px-3 py-1 rounded-full">
                    PAGADO
                </span>
                <p class="text-gray-400 text-xs mt-2">
                    {{ \Carbon\Carbon::parse($comprobante->emitido_at)->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>

        {{-- Info del hotel --}}
        <div class="bg-gray-50 px-8 py-4 border-b flex items-center justify-between">
            <div>
                <p class="font-bold text-doubletree-navy">DoubleTree by Hilton Trujillo</p>
                <p class="text-gray-500 text-sm">Av. El Golf 591, Trujillo, Perú</p>
                <p class="text-gray-500 text-sm">RUC: 20396900719</p>
            </div>
            <i class="fa fa-hotel text-4xl doubletree-gold opacity-60"></i>
        </div>

        {{-- Datos del cliente --}}
        <div class="px-8 py-5 border-b">
            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-3">
                Datos del huésped
            </h2>
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div>
                    <p class="text-gray-400">Nombre</p>
                    <p class="font-medium text-doubletree-navy">
                        {{ $comprobante->reserva->cliente->nombre }}
                        {{ $comprobante->reserva->cliente->apellido }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-400">DNI / Pasaporte</p>
                    <p class="font-medium text-doubletree-navy">
                        {{ $comprobante->reserva->cliente->dni }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-400">Correo</p>
                    <p class="font-medium text-doubletree-navy">
                        {{ $comprobante->reserva->cliente->email }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-400">Nacionalidad</p>
                    <p class="font-medium text-doubletree-navy">
                        {{ $comprobante->reserva->cliente->nacionalidad }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Detalle de la reserva --}}
        <div class="px-8 py-5 border-b">
            <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-3">
                Detalle de la reserva
            </h2>
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div>
                    <p class="text-gray-400">Habitación</p>
                    <p class="font-medium text-doubletree-navy">
                        Nº {{ $comprobante->reserva->habitacion->numero }}
                        — {{ $comprobante->reserva->habitacion->tipo->nombre }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-400">Piso</p>
                    <p class="font-medium text-doubletree-navy">
                        {{ $comprobante->reserva->habitacion->piso }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-400">Fecha ingreso</p>
                    <p class="font-medium text-doubletree-navy">
                        {{ \Carbon\Carbon::parse($comprobante->reserva->fecha_ingreso)->format('d/m/Y H:i') }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-400">Fecha salida</p>
                    <p class="font-medium text-doubletree-navy">
                        {{ \Carbon\Carbon::parse($comprobante->reserva->fecha_salida)->format('d/m/Y H:i') }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-400">Precio por noche</p>
                    <p class="font-medium text-doubletree-navy">
                        S/ {{ number_format($comprobante->reserva->precio_noche_aplicado, 2) }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-400">Método de pago</p>
                    <p class="font-medium text-doubletree-navy">
                        {{ ucfirst($comprobante->pago->metodo ?? 'MercadoPago') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Total --}}
        <div class="px-8 py-5 border-b bg-gray-50">
            <div class="flex justify-between items-center">
                <span class="text-gray-500 text-sm">Subtotal</span>
                <span class="text-doubletree-navy">
                    S/ {{ number_format($comprobante->reserva->total, 2) }}
                </span>
            </div>
            <div class="flex justify-between items-center mt-2">
                <span class="text-gray-500 text-sm">IGV (18%)</span>
                <span class="text-doubletree-navy">
                    S/ {{ number_format($comprobante->reserva->total * 0.18, 2) }}
                </span>
            </div>
            <div class="flex justify-between items-center mt-3 pt-3 border-t">
                <span class="font-bold text-doubletree-navy text-lg">Total pagado</span>
                <span class="font-bold text-2xl text-doubletree-navy">
                    S/ {{ number_format($comprobante->reserva->total, 2) }}
                </span>
            </div>
        </div>

        {{-- Estado y acciones --}}
        <div class="px-8 py-5 flex flex-col sm:flex-row gap-3 justify-between items-center">
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i class="fa fa-shield-halved text-green-500"></i>
                <span>Comprobante válido — {{ $comprobante->numero_boleta }}</span>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('reservas.index') }}"
                   class="bg-gray-100 text-gray-600 px-5 py-2 rounded-lg text-sm hover:bg-gray-200 transition">
                    <i class="fa fa-arrow-left mr-1"></i>Mis reservas
                </a>
                <button onclick="window.print()"
                        class="bg-doubletree-navy text-white px-5 py-2 rounded-lg text-sm hover:bg-blue-900 transition">
                    <i class="fa fa-print mr-1"></i>Imprimir
                </button>
            </div>
        </div>

    </div>
</div>
@endsection