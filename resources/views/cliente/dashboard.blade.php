@extends('layouts.app')
@section('title', 'Mi Panel — DoubleTree')

@section('content')
@php
    $cliente    = Auth::guard('cliente')->user();
    $reservas   = \App\Models\Reserva::with(['habitacion.tipo','pago'])
                    ->where('cliente_id', $cliente->id)
                    ->orderBy('created_at','desc')
                    ->take(5)->get();
    $totalReservas  = \App\Models\Reserva::where('cliente_id',$cliente->id)->count();
    $activas        = \App\Models\Reserva::where('cliente_id',$cliente->id)
                        ->whereIn('estado',['confirmada','en_curso'])->count();
    $completadas    = \App\Models\Reserva::where('cliente_id',$cliente->id)
                        ->where('estado','completada')->count();
    $gastado        = \App\Models\Pago::whereHas('reserva', fn($q) => $q->where('cliente_id',$cliente->id))
                        ->where('estado','aprobado')->sum('monto');
@endphp

<style>
    .client-card {
        background: #fff;
        border: 1px solid rgba(201,170,113,.15);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .client-card:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(26,58,92,.10); }
    .badge-estado {
        font-size: .6rem; padding: .15rem .5rem;
        border-radius: 20px; font-weight: 600; letter-spacing: .05em;
    }
    .quick-link {
        display: flex; align-items: center; gap: 1rem;
        padding: 1.25rem 1.5rem; text-decoration: none;
        border-bottom: 1px solid rgba(201,170,113,.12);
        transition: background 0.2s;
    }
    .quick-link:last-child { border-bottom: none; }
    .quick-link:hover { background: rgba(201,170,113,.05); }
</style>

<div class="min-h-screen" style="background:#F8F5EF">
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- ── HERO BIENVENIDA ── --}}
    <div class="relative overflow-hidden mb-8 p-8 lg:p-10"
         style="background:#1A3A5C">
        {{-- Patrón decorativo --}}
        <div class="absolute inset-0 opacity-5"
             style="background-image:repeating-linear-gradient(45deg,#C9AA71 0,#C9AA71 1px,transparent 0,transparent 30px)">
        </div>
        <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <p class="text-[10px] uppercase tracking-widest font-medium mb-2"
                   style="color:#C9AA71">DoubleTree by Hilton Trujillo</p>
                <h1 class="font-serif text-3xl sm:text-4xl font-light text-white mb-1">
                    Bienvenido, {{ $cliente->nombre }}
                </h1>
                <p class="text-sm font-light" style="color:rgba(255,255,255,.55)">
                    {{ $cliente->email }} · {{ $cliente->nacionalidad }}
                </p>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-14 h-14 flex items-center justify-center font-serif text-2xl font-light"
                     style="background:rgba(201,170,113,.15);color:#C9AA71;border:1px solid rgba(201,170,113,.3)">
                    {{ strtoupper(substr($cliente->nombre,0,1)) }}
                </div>
            </div>
        </div>
    </div>

    {{-- ── MÉTRICAS ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="client-card p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-[10px] uppercase tracking-widest font-medium"
                   style="color:rgba(26,58,92,.5)">Total reservas</p>
                <i class="fas fa-calendar text-xs" style="color:#C9AA71"></i>
            </div>
            <p class="font-serif text-2xl font-light" style="color:#1A3A5C">{{ $totalReservas }}</p>
        </div>
        <div class="client-card p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-[10px] uppercase tracking-widest font-medium"
                   style="color:rgba(26,58,92,.5)">Activas</p>
                <i class="fas fa-check-circle text-xs" style="color:#22c55e"></i>
            </div>
            <p class="font-serif text-2xl font-light" style="color:#1A3A5C">{{ $activas }}</p>
        </div>
        <div class="client-card p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-[10px] uppercase tracking-widest font-medium"
                   style="color:rgba(26,58,92,.5)">Completadas</p>
                <i class="fas fa-flag-checkered text-xs" style="color:#C9AA71"></i>
            </div>
            <p class="font-serif text-2xl font-light" style="color:#1A3A5C">{{ $completadas }}</p>
        </div>
        <div class="client-card p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-[10px] uppercase tracking-widest font-medium"
                   style="color:rgba(26,58,92,.5)">Total gastado</p>
                <i class="fas fa-coins text-xs" style="color:#C9AA71"></i>
            </div>
            <p class="font-serif text-2xl font-light" style="color:#1A3A5C">
                S/ {{ number_format($gastado, 2) }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── ACCESOS RÁPIDOS ── --}}
        <div class="client-card lg:col-span-1">
            <div class="p-5 border-b" style="border-color:rgba(201,170,113,.15)">
                <p class="text-[10px] uppercase tracking-widest font-medium mb-0.5"
                   style="color:#C9AA71">Navegación</p>
                <h2 class="font-serif text-xl font-light" style="color:#1A3A5C">Accesos rápidos</h2>
            </div>

            <a href="{{ route('habitaciones.index') }}" class="quick-link">
                <div class="w-10 h-10 flex items-center justify-center flex-shrink-0"
                     style="background:#1A3A5C">
                    <i class="fas fa-bed text-xs" style="color:#C9AA71"></i>
                </div>
                <div>
                    <p class="text-sm font-medium" style="color:#1A3A5C">Buscar habitación</p>
                    <p class="text-[11px]" style="color:rgba(26,58,92,.5)">Ver disponibilidad y reservar</p>
                </div>
                <i class="fas fa-chevron-right ml-auto text-[10px]" style="color:rgba(201,170,113,.6)"></i>
            </a>

            <a href="{{ route('reservas.index') }}" class="quick-link">
                <div class="w-10 h-10 flex items-center justify-center flex-shrink-0"
                     style="background:#1A3A5C">
                    <i class="fas fa-calendar-check text-xs" style="color:#C9AA71"></i>
                </div>
                <div>
                    <p class="text-sm font-medium" style="color:#1A3A5C">Mis reservas</p>
                    <p class="text-[11px]" style="color:rgba(26,58,92,.5)">Historial y estado actual</p>
                </div>
                <i class="fas fa-chevron-right ml-auto text-[10px]" style="color:rgba(201,170,113,.6)"></i>
            </a>

            <div class="quick-link" style="opacity:.5;cursor:not-allowed">
                <div class="w-10 h-10 flex items-center justify-center flex-shrink-0"
                     style="background:#1A3A5C">
                    <i class="fas fa-file-invoice text-xs" style="color:#C9AA71"></i>
                </div>
                <div>
                    <p class="text-sm font-medium" style="color:#1A3A5C">Comprobantes</p>
                    <p class="text-[11px]" style="color:rgba(26,58,92,.5)">Descarga tus boletas</p>
                </div>
            </div>

            {{-- Info hotel --}}
            <div class="p-5 border-t" style="border-color:rgba(201,170,113,.15)">
                <p class="text-[10px] uppercase tracking-widest font-medium mb-3"
                   style="color:#C9AA71">El hotel</p>
                <div class="space-y-2.5">
                    @foreach([
                        ['fa-location-dot','Av. El Golf 591, Trujillo'],
                        ['fa-star','4 Estrellas · Valoración 9.1'],
                        ['fa-plane','11 km del aeropuerto'],
                        ['fa-clock','Recepción 24 horas'],
                    ] as [$icon,$text])
                    <div class="flex items-center gap-2.5 text-xs" style="color:rgba(26,58,92,.6)">
                        <i class="fas {{ $icon }} text-[10px] w-4 text-center flex-shrink-0"
                           style="color:#C9AA71"></i>
                        {{ $text }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── ÚLTIMAS RESERVAS ── --}}
        <div class="client-card lg:col-span-2">
            <div class="flex items-center justify-between p-5 border-b"
                 style="border-color:rgba(201,170,113,.15)">
                <div>
                    <p class="text-[10px] uppercase tracking-widest font-medium mb-0.5"
                       style="color:#C9AA71">Historial</p>
                    <h2 class="font-serif text-xl font-light" style="color:#1A3A5C">
                        Mis últimas reservas
                    </h2>
                </div>
                <a href="{{ route('reservas.index') }}"
                   class="text-[10px] uppercase tracking-widest font-medium transition-colors"
                   style="color:#1A3A5C;border-bottom:1px solid #C9AA71;text-decoration:none">
                    Ver todas
                </a>
            </div>

            @forelse($reservas as $r)
            @php
                $cfg = [
                    'pendiente'  => ['rgba(234,179,8,.1)',  '#854d0e', 'Pendiente'],
                    'confirmada' => ['rgba(34,197,94,.1)',  '#166534', 'Confirmada'],
                    'en_curso'   => ['rgba(59,130,246,.1)', '#1e40af', 'En curso'],
                    'completada' => ['rgba(107,114,128,.1)','#374151', 'Completada'],
                    'cancelada'  => ['rgba(239,68,68,.1)',  '#991b1b', 'Cancelada'],
                ];
                [$bg,$color,$lbl] = $cfg[$r->estado] ?? ['rgba(107,114,128,.1)','#374151',$r->estado];
            @endphp
            <div class="flex items-center gap-4 p-5 border-b hover:bg-amber-50/20 transition"
                 style="border-color:rgba(201,170,113,.08)">
                <div class="w-10 h-10 flex items-center justify-center flex-shrink-0 font-serif text-lg font-light"
                     style="background:rgba(26,58,92,.06);color:#1A3A5C">
                    {{ $loop->iteration }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-0.5">
                        <p class="font-medium text-sm truncate" style="color:#1A3A5C">
                            Hab. {{ $r->habitacion->numero }} — {{ $r->habitacion->tipo->nombre }}
                        </p>
                    </div>
                    <p class="text-[11px]" style="color:rgba(26,58,92,.5)">
                        {{ \Carbon\Carbon::parse($r->fecha_ingreso)->format('d/m/Y') }}
                        →
                        {{ \Carbon\Carbon::parse($r->fecha_salida)->format('d/m/Y') }}
                    </p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="font-medium text-sm mb-1" style="color:#1A3A5C">
                        S/ {{ number_format($r->total, 2) }}
                    </p>
                    <span class="badge-estado" style="background:{{ $bg }};color:{{ $color }}">
                        {{ $lbl }}
                    </span>
                </div>
            </div>
            @empty
            <div class="p-10 text-center">
                <i class="fas fa-calendar-xmark text-3xl mb-3 block" style="color:rgba(201,170,113,.4)"></i>
                <p class="font-serif text-xl font-light mb-2" style="color:#1A3A5C">
                    Aún no tienes reservas
                </p>
                <p class="text-sm mb-5" style="color:rgba(26,58,92,.5)">
                    Descubre nuestras habitaciones y haz tu primera reserva
                </p>
                <a href="{{ route('habitaciones.index') }}"
                   class="inline-block text-white text-[10px] uppercase tracking-widest font-medium px-6 py-3 transition-all"
                   style="background:#1A3A5C;text-decoration:none">
                    Ver habitaciones
                </a>
            </div>
            @endforelse
        </div>
    </div>

</div>
</div>
@endsection