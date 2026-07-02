@extends('layouts.app')
@section('title', 'Mis Reservas')

@section('content')
<style>
    .reserva-card {
        background: #fff;
        border: 1px solid rgba(201,170,113,.15);
        transition: box-shadow 0.2s;
    }
    .reserva-card:hover { box-shadow: 0 8px 24px rgba(26,58,92,.08); }
    .badge-estado {
        font-size: .65rem; padding: .2rem .6rem;
        border-radius: 20px; font-weight: 600; letter-spacing: .05em;
        text-transform: uppercase;
    }
    .btn-accion {
        font-size: .65rem; letter-spacing: .1em; text-transform: uppercase;
        font-weight: 600; padding: .5rem 1rem;
        transition: all .2s; text-decoration: none;
        display: inline-flex; align-items: center; gap: .4rem;
        border: none; cursor: pointer;
    }
</style>

<div class="min-h-screen py-10 px-4" style="background:#F8F5EF">
<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="mb-8">
        <p class="text-[10px] uppercase tracking-widest font-medium mb-1"
           style="color:#C9AA71">Mi cuenta</p>
        <h1 class="font-serif text-3xl font-light" style="color:#1A3A5C">
            Mis Reservas
        </h1>
        <div class="flex items-center gap-2 mt-3 max-w-xs">
            <div class="h-px flex-1" style="background:rgba(201,170,113,.3)"></div>
            <i class="fas fa-star text-[8px]" style="color:#C9AA71"></i>
            <div class="h-px flex-1" style="background:rgba(201,170,113,.3)"></div>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 flex items-center gap-3 text-sm"
         style="background:rgba(34,197,94,.08);border-left:3px solid #22c55e;color:#166534">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    @if($reservas->isEmpty())
    {{-- Estado vacío --}}
    <div class="reserva-card p-14 text-center">
        <i class="fas fa-calendar-xmark text-4xl mb-4 block"
           style="color:rgba(201,170,113,.4)"></i>
        <h2 class="font-serif text-2xl font-light mb-2" style="color:#1A3A5C">
            Aún no tienes reservas
        </h2>
        <p class="text-sm mb-6" style="color:rgba(26,58,92,.5)">
            Descubre nuestras habitaciones y haz tu primera reserva
        </p>
        <a href="{{ route('habitaciones.index') }}"
           class="btn-accion text-white"
           style="background:#1A3A5C">
            <i class="fas fa-bed"></i>
            Ver habitaciones disponibles
        </a>
    </div>

    @else
    {{-- Resumen rápido --}}
    @php
        $total     = $reservas->count();
        $activas   = $reservas->whereIn('estado',['confirmada','en_curso'])->count();
        $pendientes= $reservas->where('estado','pendiente')->count();
        $gastado   = $reservas->whereIn('estado',['confirmada','en_curso','completada'])
                        ->sum('total');
    @endphp
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="reserva-card p-4 text-center">
            <p class="font-serif text-2xl font-light" style="color:#1A3A5C">{{ $total }}</p>
            <p class="text-[10px] uppercase tracking-widest mt-1" style="color:rgba(26,58,92,.5)">Total</p>
        </div>
        <div class="reserva-card p-4 text-center">
            <p class="font-serif text-2xl font-light" style="color:#1A3A5C">{{ $activas }}</p>
            <p class="text-[10px] uppercase tracking-widest mt-1" style="color:rgba(26,58,92,.5)">Activas</p>
        </div>
        <div class="reserva-card p-4 text-center">
            <p class="font-serif text-2xl font-light" style="color:#1A3A5C">
                S/ {{ number_format($gastado, 2) }}
            </p>
            <p class="text-[10px] uppercase tracking-widest mt-1" style="color:rgba(26,58,92,.5)">Gastado</p>
        </div>
    </div>

    {{-- Lista de reservas --}}
    <div class="space-y-4">
        @foreach($reservas as $reserva)
        @php
            $cfg = [
                'pendiente'  => ['rgba(234,179,8,.1)',  '#854d0e', 'Pendiente'],
                'confirmada' => ['rgba(34,197,94,.1)',  '#166534', 'Confirmada'],
                'en_curso'   => ['rgba(59,130,246,.1)', '#1e40af', 'En curso'],
                'completada' => ['rgba(107,114,128,.1)','#374151', 'Completada'],
                'cancelada'  => ['rgba(239,68,68,.1)',  '#991b1b', 'Cancelada'],
            ];
            [$bg,$color,$lbl] = $cfg[$reserva->estado] ?? ['rgba(107,114,128,.1)','#374151',$reserva->estado];
        @endphp

        <div class="reserva-card">
            <div class="flex flex-col md:flex-row">

                {{-- Franja lateral de color --}}
                <div class="w-full md:w-1.5 md:min-h-full"
                     style="background:{{ $color }};min-height:4px"></div>

                {{-- Contenido --}}
                <div class="flex-1 p-6">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">

                        {{-- Info principal --}}
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3 flex-wrap">
                                <span class="font-serif text-xl font-light"
                                      style="color:#1A3A5C">
                                    Hab. {{ $reserva->habitacion->numero }}
                                </span>
                                <span class="text-xs" style="color:rgba(26,58,92,.5)">
                                    {{ $reserva->habitacion->tipo->nombre }}
                                    · Piso {{ $reserva->habitacion->piso }}
                                </span>
                                <span class="badge-estado"
                                      style="background:{{ $bg }};color:{{ $color }}">
                                    {{ $lbl }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest mb-0.5"
                                       style="color:rgba(26,58,92,.4)">Check-in</p>
                                    <p style="color:#1A3A5C">
                                        {{ \Carbon\Carbon::parse($reserva->fecha_ingreso)->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs" style="color:rgba(26,58,92,.45)">
                                        {{ \Carbon\Carbon::parse($reserva->fecha_ingreso)->format('H:i') }} hrs
                                    </p>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest mb-0.5"
                                       style="color:rgba(26,58,92,.4)">Check-out</p>
                                    <p style="color:#1A3A5C">
                                        {{ \Carbon\Carbon::parse($reserva->fecha_salida)->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs" style="color:rgba(26,58,92,.45)">
                                        {{ \Carbon\Carbon::parse($reserva->fecha_salida)->format('H:i') }} hrs
                                    </p>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest mb-0.5"
                                       style="color:rgba(26,58,92,.4)">Total</p>
                                    <p class="font-serif text-lg font-light" style="color:#1A3A5C">
                                        S/ {{ number_format($reserva->total, 2) }}
                                    </p>
                                    <p class="text-xs" style="color:rgba(26,58,92,.45)">
                                        S/ {{ number_format($reserva->precio_noche_aplicado, 2) }}/noche
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Acciones --}}
                        <div class="flex flex-col gap-2 min-w-fit">

                            {{-- Botón PAGAR (pendiente sin pago aprobado) --}}
                            @if($reserva->estado === 'pendiente' && (!$reserva->pago || $reserva->pago->estado !== 'aprobado'))
                            <a href="{{ route('pagos.iniciar', $reserva->id) }}"
                               class="btn-accion text-white"
                               style="background:#009ee3">
                                <i class="fas fa-credit-card"></i>
                                Pagar ahora
                            </a>
                            @endif

                            {{-- Comprobante --}}
                            @if($reserva->comprobante)
                            <a href="{{ route('comprobantes.show', $reserva->comprobante->id) }}"
                               class="btn-accion"
                               style="background:rgba(26,58,92,.08);color:#1A3A5C">
                                <i class="fas fa-file-pdf"></i>
                                Comprobante
                            </a>
                            @endif

                            {{-- Cancelar --}}
                            @if(in_array($reserva->estado, ['pendiente', 'confirmada']))
                            <form method="POST"
                                  action="{{ route('reservas.cancelar', $reserva->id) }}"
                                  id="form-cancel-{{ $reserva->id }}">
                                @csrf
                                <button type="button"
                                        onclick="confirmarCancelacion({{ $reserva->id }})"
                                        class="btn-accion w-full justify-center"
                                        style="background:rgba(239,68,68,.08);color:#991b1b">
                                    <i class="fas fa-times"></i>
                                    Cancelar
                                </button>
                            </form>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Botón nueva reserva --}}
    <div class="mt-8 text-center">
        <a href="{{ route('habitaciones.index') }}"
           class="btn-accion text-white"
           style="background:#1A3A5C">
            <i class="fas fa-plus"></i>
            Nueva reserva
        </a>
    </div>
    @endif

</div>
</div>

{{-- Modal cancelar --}}
<div id="modal-cancelar"
     class="fixed inset-0 z-50 hidden items-center justify-center"
     style="background:rgba(0,0,0,.5)">
    <div class="bg-white p-8 max-w-sm w-full mx-4" style="border-top:3px solid #ef4444">
        <div class="text-center">
            <div class="w-14 h-14 flex items-center justify-center mx-auto mb-4"
                 style="background:rgba(239,68,68,.08)">
                <i class="fas fa-triangle-exclamation text-xl" style="color:#ef4444"></i>
            </div>
            <h3 class="font-serif text-xl font-light mb-2" style="color:#1A3A5C">
                ¿Cancelar reserva?
            </h3>
            <p class="text-sm mb-6" style="color:rgba(26,58,92,.6)">
                Esta acción no se puede deshacer. La habitación quedará disponible nuevamente.
            </p>
            <div class="flex gap-3">
                <button onclick="cerrarModalCancelacion()"
                        class="flex-1 py-2.5 text-sm font-medium"
                        style="background:#f3f4f6;color:#4b5563">
                    Mantener reserva
                </button>
                <button id="btnConfirmarCancelacion"
                        class="flex-1 py-2.5 text-sm font-medium text-white"
                        style="background:#ef4444">
                    Sí, cancelar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let formIdCancelacion = null;

function confirmarCancelacion(id) {
    formIdCancelacion = id;
    const m = document.getElementById('modal-cancelar');
    m.classList.remove('hidden');
    m.classList.add('flex');
}

function cerrarModalCancelacion() {
    const m = document.getElementById('modal-cancelar');
    m.classList.add('hidden');
    m.classList.remove('flex');
    formIdCancelacion = null;
}

document.getElementById('btnConfirmarCancelacion').addEventListener('click', () => {
    if (formIdCancelacion) {
        document.getElementById('form-cancel-' + formIdCancelacion).submit();
    }
});

document.getElementById('modal-cancelar').addEventListener('click', function(e) {
    if (e.target === this) cerrarModalCancelacion();
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') cerrarModalCancelacion();
});
</script>

@endsection