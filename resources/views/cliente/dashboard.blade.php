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
    $pendientes     = \App\Models\Reserva::where('cliente_id',$cliente->id)
                        ->where('estado','pendiente')->count();
@endphp

<style>
html { scroll-behavior: smooth; }

.db-surface {
    background: var(--surface-2);
    border: 0.5px solid var(--border);
    border-radius: 12px;
}

.db-hero {
    background: #1A3A5C;
    border-radius: 12px;
    position: relative;
    overflow: hidden;
}
.db-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: repeating-linear-gradient(
        45deg,
        rgba(201,170,113,.06) 0,
        rgba(201,170,113,.06) 1px,
        transparent 0,
        transparent 28px
    );
}

.db-stat {
    background: var(--surface-2);
    border: 0.5px solid var(--border);
    border-radius: 12px;
    padding: 1.25rem;
    position: relative;
    overflow: hidden;
    transition: box-shadow .2s;
}
.db-stat:hover { box-shadow: 0 4px 20px rgba(26,58,92,.08); }
.db-stat-accent {
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
}

.db-nav-item {
    display: flex;
    align-items: center;
    gap: .875rem;
    padding: .875rem 1.25rem;
    text-decoration: none;
    border-radius: 8px;
    transition: background .15s;
    color: var(--text-secondary);
    font-size: .8125rem;
    font-weight: 400;
}
.db-nav-item:hover { background: var(--surface-1); color: var(--text-primary); }
.db-nav-item .db-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    background: rgba(26,58,92,.07);
    flex-shrink: 0;
    font-size: 14px;
    color: #1A3A5C;
}

.db-reserva-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: .875rem 1.25rem;
    border-bottom: 0.5px solid var(--border);
    transition: background .15s;
}
.db-reserva-row:last-child { border-bottom: none; }
.db-reserva-row:hover { background: var(--surface-1); }

.db-badge {
    font-size: .6rem;
    font-weight: 600;
    letter-spacing: .06em;
    text-transform: uppercase;
    padding: .2rem .55rem;
    border-radius: 20px;
    white-space: nowrap;
}

.db-hotel-item {
    display: flex;
    align-items: center;
    gap: .625rem;
    font-size: .75rem;
    color: var(--text-secondary);
    padding: .35rem 0;
}
.db-hotel-item i { color: #C9AA71; font-size: 13px; width: 16px; text-align: center; }

.db-section-label {
    font-size: .625rem;
    font-weight: 500;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: #C9AA71;
    margin-bottom: .375rem;
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}
.fade-up { animation: fadeUp .45s ease forwards; }
.delay-1 { animation-delay: .08s; opacity: 0; }
.delay-2 { animation-delay: .16s; opacity: 0; }
.delay-3 { animation-delay: .24s; opacity: 0; }
.delay-4 { animation-delay: .32s; opacity: 0; }
</style>

<div style="background: var(--surface-0); min-height: 100vh; padding: 2rem 1rem 3rem;">
<div style="max-width: 1100px; margin: 0 auto;">

    {{-- ── HERO ── --}}
    <div class="db-hero fade-up mb-6 p-7">
        <div style="position: relative; z-index: 1; display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; flex-wrap: wrap;">
            <div>
                <div class="db-section-label" style="margin-bottom: .5rem;">
                    DoubleTree by Hilton Trujillo
                </div>
                <h1 style="font-family: var(--font-voice); font-size: 2rem; font-weight: 400; color: #fff; line-height: 1.2; margin: 0 0 .375rem;">
                    Bienvenido, {{ $cliente->nombre }}
                </h1>
                <p style="font-size: .8125rem; color: rgba(255,255,255,.5); margin: 0;">
                    {{ $cliente->email }}
                    @if($cliente->nacionalidad)
                        &nbsp;·&nbsp; {{ $cliente->nacionalidad }}
                    @endif
                </p>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem;">
                @if($pendientes > 0)
                <a href="{{ route('reservas.index') }}"
                   style="font-size: .7rem; letter-spacing: .1em; text-transform: uppercase; font-weight: 500;
                          background: rgba(239,68,68,.15); color: #fca5a5; border: 0.5px solid rgba(239,68,68,.3);
                          padding: .5rem 1rem; border-radius: 8px; text-decoration: none; white-space: nowrap;">
                    <i class="fas fa-clock" style="margin-right: .4rem;"></i>
                    {{ $pendientes }} pendiente{{ $pendientes > 1 ? 's' : '' }}
                </a>
                @endif
                <div style="width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
                            font-family: var(--font-voice); font-size: 1.25rem; font-weight: 400;
                            background: rgba(201,170,113,.15); color: #C9AA71; border: 0.5px solid rgba(201,170,113,.3);">
                    {{ strtoupper(substr($cliente->nombre,0,1)) }}
                </div>
            </div>
        </div>
    </div>

    {{-- ── MÉTRICAS ── --}}
    <div class="fade-up delay-1" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: .75rem; margin-bottom: 1.5rem;">

        <div class="db-stat">
            <div class="db-stat-accent" style="background: #C9AA71;"></div>
            <p style="font-size: .65rem; font-weight: 500; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); margin: 0 0 .625rem .5rem;">
                Total reservas
            </p>
            <div style="display: flex; align-items: baseline; gap: .5rem; padding-left: .5rem;">
                <span style="font-family: var(--font-voice); font-size: 2rem; font-weight: 400; color: var(--text-primary); line-height: 1;">
                    {{ $totalReservas }}
                </span>
                <span style="font-size: .75rem; color: var(--text-muted);">estancias</span>
            </div>
        </div>

        <div class="db-stat">
            <div class="db-stat-accent" style="background: #22c55e;"></div>
            <p style="font-size: .65rem; font-weight: 500; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); margin: 0 0 .625rem .5rem;">
                Activas ahora
            </p>
            <div style="display: flex; align-items: baseline; gap: .5rem; padding-left: .5rem;">
                <span style="font-family: var(--font-voice); font-size: 2rem; font-weight: 400; color: var(--text-primary); line-height: 1;">
                    {{ $activas }}
                </span>
                <span style="font-size: .75rem; color: var(--text-muted);">en curso</span>
            </div>
        </div>

        <div class="db-stat">
            <div class="db-stat-accent" style="background: #6366f1;"></div>
            <p style="font-size: .65rem; font-weight: 500; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); margin: 0 0 .625rem .5rem;">
                Completadas
            </p>
            <div style="display: flex; align-items: baseline; gap: .5rem; padding-left: .5rem;">
                <span style="font-family: var(--font-voice); font-size: 2rem; font-weight: 400; color: var(--text-primary); line-height: 1;">
                    {{ $completadas }}
                </span>
                <span style="font-size: .75rem; color: var(--text-muted);">estancias</span>
            </div>
        </div>

        <div class="db-stat">
            <div class="db-stat-accent" style="background: #C9AA71;"></div>
            <p style="font-size: .65rem; font-weight: 500; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); margin: 0 0 .625rem .5rem;">
                Total invertido
            </p>
            <div style="display: flex; align-items: baseline; gap: .375rem; padding-left: .5rem; flex-wrap: wrap;">
                <span style="font-size: .875rem; color: var(--text-muted); font-weight: 400;">S/</span>
                <span style="font-family: var(--font-voice); font-size: 2rem; font-weight: 400; color: var(--text-primary); line-height: 1;">
                    {{ number_format($gastado, 0) }}
                </span>
            </div>
        </div>

    </div>

    {{-- ── GRID PRINCIPAL ── --}}
    <div class="fade-up delay-2" style="display: grid; grid-template-columns: 280px 1fr; gap: 1rem; align-items: start;">

        {{-- ── PANEL LATERAL ── --}}
        <div style="display: flex; flex-direction: column; gap: .75rem;">

            {{-- Navegación --}}
            <div class="db-surface" style="padding: 1.25rem;">
                <div class="db-section-label">Navegación</div>
                <div style="display: flex; flex-direction: column; gap: .25rem; margin-top: .625rem;">

                    <a href="{{ route('habitaciones.index') }}" class="db-nav-item">
                        <div class="db-icon"><i class="fas fa-bed"></i></div>
                        <div>
                            <div style="font-weight: 500; color: var(--text-primary);">Buscar habitación</div>
                            <div style="font-size: .7rem; color: var(--text-muted);">Ver disponibilidad</div>
                        </div>
                        <i class="fas fa-chevron-right" style="margin-left: auto; font-size: 10px; color: var(--text-muted);"></i>
                    </a>

                    <a href="{{ route('reservas.index') }}" class="db-nav-item">
                        <div class="db-icon"><i class="fas fa-calendar-check"></i></div>
                        <div>
                            <div style="font-weight: 500; color: var(--text-primary);">Mis reservas</div>
                            <div style="font-size: .7rem; color: var(--text-muted);">Historial completo</div>
                        </div>
                        @if($pendientes > 0)
                        <span class="db-badge" style="margin-left: auto; background: rgba(239,68,68,.1); color: #991b1b;">
                            {{ $pendientes }}
                        </span>
                        @else
                        <i class="fas fa-chevron-right" style="margin-left: auto; font-size: 10px; color: var(--text-muted);"></i>
                        @endif
                    </a>

                    <div class="db-nav-item" style="opacity: .45; cursor: not-allowed;">
                        <div class="db-icon"><i class="fas fa-file-invoice"></i></div>
                        <div>
                            <div style="font-weight: 500; color: var(--text-primary);">Comprobantes</div>
                            <div style="font-size: .7rem; color: var(--text-muted);">Descarga boletas</div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Info del hotel --}}
            <div class="db-surface" style="padding: 1.25rem;">
                <div class="db-section-label">El hotel</div>
                <div style="margin-top: .625rem;">
                    @foreach([
                        ['fa-location-dot','Av. El Golf 591, Trujillo'],
                        ['fa-star','5 Estrellas · Valoración 9.1'],
                        ['fa-plane','11 km del aeropuerto'],
                        ['fa-clock','Recepción 24 horas'],
                        ['fa-wifi','WiFi de alta velocidad'],
                    ] as [$icon,$text])
                    <div class="db-hotel-item">
                        <i class="fas {{ $icon }}"></i>
                        <span>{{ $text }}</span>
                    </div>
                    @endforeach
                </div>
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 0.5px solid var(--border);">
                    <a href="{{ route('habitaciones.index') }}"
                       style="display: block; text-align: center; font-size: .7rem; letter-spacing: .1em;
                              text-transform: uppercase; font-weight: 500; padding: .625rem;
                              background: #1A3A5C; color: #fff; border-radius: 8px; text-decoration: none;
                              transition: opacity .2s;"
                       onmouseover="this.style.opacity='.85'"
                       onmouseout="this.style.opacity='1'">
                        <i class="fas fa-plus" style="margin-right: .4rem; font-size: 10px;"></i>
                        Nueva reserva
                    </a>
                </div>
            </div>

        </div>

        {{-- ── ÚLTIMAS RESERVAS ── --}}
        <div class="db-surface" style="overflow: hidden;">
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 1.25rem; border-bottom: 0.5px solid var(--border);">
                <div>
                    <div class="db-section-label">Actividad reciente</div>
                    <h2 style="font-family: var(--font-voice); font-size: 1.25rem; font-weight: 400; color: var(--text-primary); margin: 0;">
                        Últimas reservas
                    </h2>
                </div>
                <a href="{{ route('reservas.index') }}"
                   style="font-size: .7rem; letter-spacing: .08em; text-transform: uppercase; font-weight: 500;
                          color: #1A3A5C; text-decoration: none; border-bottom: 1px solid #C9AA71; padding-bottom: 1px;">
                    Ver todas
                </a>
            </div>

            @forelse($reservas as $r)
            @php
                $cfg = [
                    'pendiente'  => ['rgba(234,179,8,.12)',  '#854d0e', 'Pendiente',  '#eab308'],
                    'confirmada' => ['rgba(34,197,94,.12)',  '#166534', 'Confirmada', '#22c55e'],
                    'en_curso'   => ['rgba(59,130,246,.12)', '#1e40af', 'En curso',   '#3b82f6'],
                    'completada' => ['rgba(107,114,128,.12)','#374151', 'Completada', '#6b7280'],
                    'cancelada'  => ['rgba(239,68,68,.12)',  '#991b1b', 'Cancelada',  '#ef4444'],
                ];
                [$bg,$color,$lbl,$dot] = $cfg[$r->estado] ?? ['rgba(107,114,128,.12)','#374151',$r->estado,'#6b7280'];
            @endphp
            <div class="db-reserva-row">
                {{-- Dot estado --}}
                <div style="width: 8px; height: 8px; border-radius: 50%; background: {{ $dot }}; flex-shrink: 0;"></div>

                {{-- Número --}}
                <div style="width: 32px; text-align: center; flex-shrink: 0;">
                    <span style="font-family: var(--font-voice); font-size: 1.1rem; color: var(--text-muted); font-weight: 400;">
                        {{ $loop->iteration }}
                    </span>
                </div>

                {{-- Info --}}
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; align-items: center; gap: .5rem; margin-bottom: .2rem; flex-wrap: wrap;">
                        <span style="font-size: .875rem; font-weight: 500; color: var(--text-primary);">
                            Hab. {{ $r->habitacion->numero }}
                        </span>
                        <span style="font-size: .75rem; color: var(--text-muted);">
                            — {{ $r->habitacion->tipo->nombre }} · Piso {{ $r->habitacion->piso }}
                        </span>
                    </div>
                    <span style="font-size: .7rem; color: var(--text-muted);">
                        <i class="fas fa-calendar-alt" style="margin-right: .3rem; font-size: 10px;"></i>
                        {{ \Carbon\Carbon::parse($r->fecha_ingreso)->format('d/m/Y') }}
                        <span style="margin: 0 .3rem;">→</span>
                        {{ \Carbon\Carbon::parse($r->fecha_salida)->format('d/m/Y') }}
                    </span>
                </div>

                {{-- Total + estado --}}
                <div style="text-align: right; flex-shrink: 0;">
                    <div style="font-size: .9375rem; font-weight: 500; color: var(--text-primary); margin-bottom: .25rem;">
                        S/ {{ number_format($r->total, 2) }}
                    </div>
                    <span class="db-badge" style="background: {{ $bg }}; color: {{ $color }};">
                        {{ $lbl }}
                    </span>
                </div>

                {{-- Acción rápida --}}
                <div style="flex-shrink: 0; margin-left: .5rem;">
                    @if($r->estado === 'pendiente' && (!$r->pago || $r->pago->estado !== 'aprobado'))
                    <a href="{{ route('pagos.iniciar', $r->id) }}"
                       style="display: inline-flex; align-items: center; gap: .35rem; font-size: .65rem;
                              letter-spacing: .08em; text-transform: uppercase; font-weight: 500;
                              background: #009ee3; color: #fff; padding: .4rem .75rem;
                              border-radius: 6px; text-decoration: none; white-space: nowrap;">
                        <i class="fas fa-credit-card" style="font-size: 10px;"></i>
                        Pagar
                    </a>
                    @elseif($r->comprobante)
                    <a href="{{ route('comprobantes.show', $r->comprobante->id) }}"
                       style="display: inline-flex; align-items: center; gap: .35rem; font-size: .65rem;
                              letter-spacing: .08em; text-transform: uppercase; font-weight: 500;
                              background: var(--surface-1); color: var(--text-secondary);
                              border: 0.5px solid var(--border-strong); padding: .4rem .75rem;
                              border-radius: 6px; text-decoration: none; white-space: nowrap;">
                        <i class="fas fa-file-pdf" style="font-size: 10px;"></i>
                        PDF
                    </a>
                    @else
                    <span style="font-size: .65rem; color: var(--text-muted);">—</span>
                    @endif
                </div>
            </div>
            @empty
            <div style="padding: 3.5rem 1.5rem; text-align: center;">
                <i class="fas fa-calendar-xmark" style="font-size: 2rem; color: rgba(201,170,113,.4); display: block; margin-bottom: 1rem;"></i>
                <p style="font-family: var(--font-voice); font-size: 1.25rem; font-weight: 400; color: var(--text-primary); margin: 0 0 .5rem;">
                    Aún no tienes reservas
                </p>
                <p style="font-size: .8125rem; color: var(--text-muted); margin: 0 0 1.5rem;">
                    Descubre nuestras habitaciones y haz tu primera reserva.
                </p>
                <a href="{{ route('habitaciones.index') }}"
                   style="display: inline-block; font-size: .7rem; letter-spacing: .1em; text-transform: uppercase;
                          font-weight: 500; padding: .625rem 1.5rem; background: #1A3A5C; color: #fff;
                          border-radius: 8px; text-decoration: none;">
                    Ver habitaciones
                </a>
            </div>
            @endforelse

        </div>

    </div>

</div>
</div>
@endsection