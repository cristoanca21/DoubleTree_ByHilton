@extends('layouts.app')
@section('title', 'Procesar Pago')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-10"
     style="background:#F8F5EF">

    <div class="w-full max-w-lg">

        {{-- Header --}}
        <div class="text-center mb-6">
            <p class="text-[10px] uppercase tracking-widest font-medium mb-2"
               style="color:#C9AA71">Pago seguro</p>
            <h1 class="font-serif text-3xl font-light" style="color:#1A3A5C">
                Confirmar reserva
            </h1>
            <div class="flex items-center gap-2 mt-3 max-w-xs mx-auto">
                <div class="h-px flex-1" style="background:rgba(201,170,113,.3)"></div>
                <i class="fas fa-lock text-[10px]" style="color:#C9AA71"></i>
                <div class="h-px flex-1" style="background:rgba(201,170,113,.3)"></div>
            </div>
        </div>

        {{-- Card --}}
        <div class="bg-white" style="border:1px solid rgba(201,170,113,.2)">

            {{-- Resumen reserva --}}
            <div class="p-6 border-b" style="border-color:rgba(201,170,113,.15)">
                <p class="text-[10px] uppercase tracking-widest font-medium mb-4"
                   style="color:#C9AA71">Detalle de la reserva</p>

                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm" style="color:rgba(26,58,92,.55)">Reserva</span>
                        <span class="text-sm font-medium" style="color:#1A3A5C">#{{ $reserva->id }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm" style="color:rgba(26,58,92,.55)">Habitación</span>
                        <span class="text-sm font-medium" style="color:#1A3A5C">
                            Nº {{ $reserva->habitacion->numero }}
                            — {{ $reserva->habitacion->tipo->nombre }}
                            · Piso {{ $reserva->habitacion->piso }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm" style="color:rgba(26,58,92,.55)">Check-in</span>
                        <span class="text-sm font-medium" style="color:#1A3A5C">
                            {{ \Carbon\Carbon::parse($reserva->fecha_ingreso)->format('d/m/Y H:i') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm" style="color:rgba(26,58,92,.55)">Check-out</span>
                        <span class="text-sm font-medium" style="color:#1A3A5C">
                            {{ \Carbon\Carbon::parse($reserva->fecha_salida)->format('d/m/Y H:i') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm" style="color:rgba(26,58,92,.55)">Precio por noche</span>
                        <span class="text-sm font-medium" style="color:#1A3A5C">
                            S/ {{ number_format($reserva->precio_noche_aplicado, 2) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Total --}}
            <div class="p-6 border-b" style="border-color:rgba(201,170,113,.15);background:rgba(201,170,113,.04)">
                <div class="flex justify-between items-center">
                    <span class="font-serif text-xl font-light" style="color:#1A3A5C">Total a pagar</span>
                    <span class="font-serif text-3xl font-light" style="color:#1A3A5C">
                        S/ {{ number_format($reserva->total, 2) }}
                    </span>
                </div>
                <p class="text-[11px] mt-1" style="color:rgba(26,58,92,.4)">
                    Incluye todos los impuestos y cargos
                </p>
            </div>

            {{-- Botón pagar --}}
            <div class="p-6 space-y-3">

                {{-- Botón real que llama al controller --}}
                <a href="{{ route('pagos.iniciar', $reserva) }}"
                   class="flex items-center justify-center gap-3 w-full py-4 text-white text-sm font-semibold tracking-wide uppercase transition-all duration-200 hover:opacity-90"
                   style="background:#009ee3;text-decoration:none">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z" fill="white" opacity=".5"/>
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" fill="white"/>
                    </svg>
                    Pagar con MercadoPago
                </a>

                <a href="{{ route('reservas.index') }}"
                   class="flex items-center justify-center w-full py-3 text-xs uppercase tracking-widest transition-all duration-200"
                   style="color:rgba(26,58,92,.5);text-decoration:none;border:1px solid rgba(201,170,113,.3)">
                    <i class="fas fa-arrow-left mr-2 text-[10px]"></i>
                    Volver a mis reservas
                </a>
            </div>

            {{-- Trust badges --}}
            <div class="px-6 pb-6 flex items-center justify-center gap-6"
                 style="color:rgba(26,58,92,.35)">
                <span class="flex items-center gap-1.5 text-[10px]">
                    <i class="fas fa-shield-halved text-sm" style="color:rgba(201,170,113,.6)"></i>
                    Pago seguro
                </span>
                <span class="flex items-center gap-1.5 text-[10px]">
                    <i class="fas fa-lock text-sm" style="color:rgba(201,170,113,.6)"></i>
                    SSL Encriptado
                </span>
                <span class="flex items-center gap-1.5 text-[10px]">
                    <i class="fas fa-rotate-left text-sm" style="color:rgba(201,170,113,.6)"></i>
                    Cancelación disponible
                </span>
            </div>
        </div>

        {{-- Métodos aceptados --}}
        <div class="mt-4 text-center">
            <p class="text-[10px] uppercase tracking-widest mb-3" style="color:rgba(26,58,92,.4)">
                Métodos de pago aceptados
            </p>
            <div class="flex items-center justify-center gap-4" style="color:rgba(26,58,92,.4)">
                <i class="fab fa-cc-visa text-2xl"></i>
                <i class="fab fa-cc-mastercard text-2xl"></i>
                <span class="text-xs font-bold border px-2 py-0.5" style="border-color:rgba(26,58,92,.2)">Yape</span>
                <span class="text-xs font-bold border px-2 py-0.5" style="border-color:rgba(26,58,92,.2)">Plin</span>
            </div>
        </div>

    </div>
</div>
@endsection