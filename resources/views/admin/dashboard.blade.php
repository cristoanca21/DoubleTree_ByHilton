@extends('layouts.app')
@section('title', 'Panel Admin — DoubleTree')

@section('content')
@php
    $admin     = Auth::guard('cliente')->user();
    $totalHab  = \App\Models\Habitacion::count();
    $ocupadas  = \App\Models\Habitacion::where('estado','ocupada')->count();
    $hoy       = \App\Models\Reserva::whereDate('created_at', today())->count();
    $pendientes= \App\Models\Reserva::where('estado','pendiente')->count();
    $confirmadas=\App\Models\Reserva::where('estado','confirmada')->count();
    $ingresos  = \App\Models\Pago::where('estado','aprobado')
                    ->whereMonth('created_at', now()->month)->sum('monto');
    $ultimasReservas = \App\Models\Reserva::with(['cliente','habitacion.tipo'])
                    ->orderBy('created_at','desc')->take(5)->get();
@endphp

<style>
    .admin-card {
        background: #fff;
        border: 1px solid rgba(201,170,113,.15);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .admin-card:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(26,58,92,.10); }
    .stat-card { padding: 1.5rem; }
    .nav-item {
        display: flex; align-items: center; gap: .75rem;
        padding: .75rem 1rem; font-size: .75rem;
        letter-spacing: .08em; text-transform: uppercase; font-weight: 500;
        color: rgba(26,58,92,.6); transition: all .2s;
        border-left: 2px solid transparent;
        text-decoration: none;
    }
    .nav-item:hover, .nav-item.active {
        color: #1A3A5C; background: rgba(201,170,113,.08);
        border-left-color: #C9AA71;
    }
    .badge {
        font-size: .6rem; padding: .15rem .5rem;
        border-radius: 20px; font-weight: 600; letter-spacing: .05em;
    }
</style>

<div class="min-h-screen" style="background:#F8F5EF">
<div class="flex">

    {{-- ══ SIDEBAR ══ --}}
    <aside class="hidden lg:flex flex-col w-64 min-h-screen sticky top-0"
           style="background:#1A3A5C;top:72px;height:calc(100vh - 72px)">

        {{-- Admin info --}}
        <div class="p-6 border-b" style="border-color:rgba(255,255,255,.1)">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-serif text-lg font-light"
                     style="background:rgba(201,170,113,.2);color:#C9AA71">
                    {{ strtoupper(substr($admin->nombre,0,1)) }}
                </div>
                <div>
                    <p class="text-white text-sm font-medium">{{ $admin->nombre }} {{ $admin->apellido }}</p>
                    <p class="text-[10px] uppercase tracking-widest" style="color:#C9AA71">Administrador</p>
                </div>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 py-4">
            <p class="px-4 mb-2 text-[9px] uppercase tracking-widest" style="color:rgba(255,255,255,.3)">
                Gestión
            </p>
            <a href="{{ route('admin.dashboard') }}" class="nav-item active"
               style="color:#C9AA71;border-left-color:#C9AA71;background:rgba(201,170,113,.1)">
                <i class="fas fa-gauge-high text-sm"></i>Dashboard
            </a>
            <a href="{{ route('admin.habitaciones.index') }}" class="nav-item" style="color:rgba(255,255,255,.6)">
                <i class="fas fa-bed text-sm"></i>Habitaciones
                @if($ocupadas > 0)
                    <span class="badge ml-auto" style="background:rgba(201,170,113,.2);color:#C9AA71">
                        {{ $ocupadas }}
                    </span>
                @endif
            </a>
            <a href="{{ route('admin.reservas.index') }}" class="nav-item" style="color:rgba(255,255,255,.6)">
                <i class="fas fa-calendar-check text-sm"></i>Reservas
                @if($pendientes > 0)
                    <span class="badge ml-auto" style="background:rgba(239,68,68,.2);color:#fca5a5">
                        {{ $pendientes }}
                    </span>
                @endif
            </a>
            <a href="{{ route('admin.reportes.index') }}" class="nav-item" style="color:rgba(255,255,255,.6)">
                <i class="fas fa-chart-line text-sm"></i>Reportes
            </a>

            <div class="mt-4 pt-4 mx-4" style="border-top:1px solid rgba(255,255,255,.1)">
                <p class="mb-2 text-[9px] uppercase tracking-widest" style="color:rgba(255,255,255,.3)">Sistema</p>
                <a href="{{ route('welcome') }}" class="nav-item" style="color:rgba(255,255,255,.6)">
                    <i class="fas fa-globe text-sm"></i>Ver sitio
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-item w-full text-left" style="color:rgba(255,255,255,.6);background:none;border:none;cursor:pointer">
                        <i class="fas fa-right-from-bracket text-sm"></i>Cerrar sesión
                    </button>
                </form>
            </div>
        </nav>

        {{-- Footer sidebar --}}
        <div class="p-4 text-[9px] uppercase tracking-widest" style="color:rgba(255,255,255,.2)">
            DoubleTree by Hilton Trujillo
        </div>
    </aside>

    {{-- ══ CONTENIDO PRINCIPAL ══ --}}
    <main class="flex-1 p-6 lg:p-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <p class="text-[10px] uppercase tracking-widest font-medium mb-1" style="color:#C9AA71">
                    Panel de Control
                </p>
                <h1 class="font-serif text-3xl font-light" style="color:#1A3A5C">
                    Bienvenido, {{ $admin->nombre }}
                </h1>
            </div>
            <div class="hidden sm:flex items-center gap-2 text-xs" style="color:rgba(26,58,92,.5)">
                <i class="fas fa-clock text-xs" style="color:#C9AA71"></i>
                {{ now()->format('d/m/Y · H:i') }}
            </div>
        </div>

        {{-- ── MÉTRICAS ── --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

            <div class="admin-card stat-card">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[10px] uppercase tracking-widest font-medium" style="color:rgba(26,58,92,.5)">
                        Ingresos del mes
                    </p>
                    <div class="w-8 h-8 flex items-center justify-center rounded"
                         style="background:rgba(201,170,113,.1)">
                        <i class="fas fa-coins text-xs" style="color:#C9AA71"></i>
                    </div>
                </div>
                <p class="font-serif text-2xl font-light" style="color:#1A3A5C">
                    S/ {{ number_format($ingresos, 2) }}
                </p>
                <p class="text-[10px] mt-1" style="color:rgba(26,58,92,.4)">
                    {{ now()->format('F Y') }}
                </p>
            </div>

            <div class="admin-card stat-card">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[10px] uppercase tracking-widest font-medium" style="color:rgba(26,58,92,.5)">
                        Ocupación
                    </p>
                    <div class="w-8 h-8 flex items-center justify-center rounded"
                         style="background:rgba(201,170,113,.1)">
                        <i class="fas fa-bed text-xs" style="color:#C9AA71"></i>
                    </div>
                </div>
                <p class="font-serif text-2xl font-light" style="color:#1A3A5C">
                    {{ $ocupadas }} / {{ $totalHab }}
                </p>
                <div class="mt-2 h-1.5 rounded-full" style="background:rgba(26,58,92,.08)">
                    <div class="h-1.5 rounded-full" style="background:#C9AA71;width:{{ $totalHab > 0 ? round($ocupadas/$totalHab*100) : 0 }}%"></div>
                </div>
                <p class="text-[10px] mt-1" style="color:rgba(26,58,92,.4)">
                    {{ $totalHab > 0 ? round($ocupadas/$totalHab*100) : 0 }}% ocupado
                </p>
            </div>

            <div class="admin-card stat-card">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[10px] uppercase tracking-widest font-medium" style="color:rgba(26,58,92,.5)">
                        Reservas hoy
                    </p>
                    <div class="w-8 h-8 flex items-center justify-center rounded"
                         style="background:rgba(201,170,113,.1)">
                        <i class="fas fa-calendar-day text-xs" style="color:#C9AA71"></i>
                    </div>
                </div>
                <p class="font-serif text-2xl font-light" style="color:#1A3A5C">{{ $hoy }}</p>
                <p class="text-[10px] mt-1" style="color:rgba(26,58,92,.4)">
                    nuevas reservas
                </p>
            </div>

            <div class="admin-card stat-card">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-[10px] uppercase tracking-widest font-medium" style="color:rgba(26,58,92,.5)">
                        Pendientes
                    </p>
                    <div class="w-8 h-8 flex items-center justify-center rounded"
                         style="background:rgba(239,68,68,.08)">
                        <i class="fas fa-clock text-xs" style="color:#ef4444"></i>
                    </div>
                </div>
                <p class="font-serif text-2xl font-light" style="color:#1A3A5C">{{ $pendientes }}</p>
                <p class="text-[10px] mt-1" style="color:rgba(26,58,92,.4)">
                    por confirmar
                </p>
            </div>
        </div>

        {{-- ── ACCESOS RÁPIDOS ── --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">

            <a href="{{ route('admin.habitaciones.index') }}"
               class="admin-card p-6 flex items-center gap-4 group" style="text-decoration:none">
                <div class="w-12 h-12 flex items-center justify-center flex-shrink-0"
                     style="background:#1A3A5C">
                    <i class="fas fa-bed" style="color:#C9AA71"></i>
                </div>
                <div>
                    <p class="font-serif text-lg font-light" style="color:#1A3A5C">Habitaciones</p>
                    <p class="text-xs mt-0.5" style="color:rgba(26,58,92,.5)">
                        Estados y disponibilidad
                    </p>
                </div>
                <i class="fas fa-arrow-right ml-auto text-xs opacity-0 group-hover:opacity-100 transition-all" style="color:#C9AA71"></i>
            </a>

            <a href="{{ route('admin.reservas.index') }}"
               class="admin-card p-6 flex items-center gap-4 group" style="text-decoration:none">
                <div class="w-12 h-12 flex items-center justify-center flex-shrink-0"
                     style="background:#1A3A5C">
                    <i class="fas fa-calendar-check" style="color:#C9AA71"></i>
                </div>
                <div>
                    <p class="font-serif text-lg font-light" style="color:#1A3A5C">Reservas</p>
                    <p class="text-xs mt-0.5" style="color:rgba(26,58,92,.5)">
                        Check-in · Check-out
                    </p>
                </div>
                <i class="fas fa-arrow-right ml-auto text-xs opacity-0 group-hover:opacity-100 transition-all" style="color:#C9AA71"></i>
            </a>

            <a href="{{ route('admin.reportes.index') }}"
               class="admin-card p-6 flex items-center gap-4 group" style="text-decoration:none">
                <div class="w-12 h-12 flex items-center justify-center flex-shrink-0"
                     style="background:#1A3A5C">
                    <i class="fas fa-chart-line" style="color:#C9AA71"></i>
                </div>
                <div>
                    <p class="font-serif text-lg font-light" style="color:#1A3A5C">Reportes</p>
                    <p class="text-xs mt-0.5" style="color:rgba(26,58,92,.5)">
                        Ingresos y ocupación
                    </p>
                </div>
                <i class="fas fa-arrow-right ml-auto text-xs opacity-0 group-hover:opacity-100 transition-all" style="color:#C9AA71"></i>
            </a>
        </div>

        {{-- ── ÚLTIMAS RESERVAS ── --}}
        <div class="admin-card">
            <div class="flex items-center justify-between p-6 border-b" style="border-color:rgba(201,170,113,.15)">
                <div>
                    <p class="text-[10px] uppercase tracking-widest font-medium mb-0.5" style="color:#C9AA71">
                        Actividad reciente
                    </p>
                    <h2 class="font-serif text-xl font-light" style="color:#1A3A5C">Últimas reservas</h2>
                </div>
                <a href="{{ route('admin.reservas.index') }}"
                   class="text-[10px] uppercase tracking-widest font-medium transition-colors"
                   style="color:#1A3A5C;border-bottom:1px solid #C9AA71;text-decoration:none">
                    Ver todas
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr style="border-bottom:1px solid rgba(201,170,113,.15)">
                            <th class="text-left p-4 text-[10px] uppercase tracking-widest font-medium"
                                style="color:rgba(26,58,92,.4)">#</th>
                            <th class="text-left p-4 text-[10px] uppercase tracking-widest font-medium"
                                style="color:rgba(26,58,92,.4)">Cliente</th>
                            <th class="text-left p-4 text-[10px] uppercase tracking-widest font-medium"
                                style="color:rgba(26,58,92,.4)">Habitación</th>
                            <th class="text-left p-4 text-[10px] uppercase tracking-widest font-medium"
                                style="color:rgba(26,58,92,.4)">Ingreso</th>
                            <th class="text-left p-4 text-[10px] uppercase tracking-widest font-medium"
                                style="color:rgba(26,58,92,.4)">Total</th>
                            <th class="text-left p-4 text-[10px] uppercase tracking-widest font-medium"
                                style="color:rgba(26,58,92,.4)">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ultimasReservas as $r)
                        @php
                            $badges = [
                                'pendiente'  => ['bg:rgba(234,179,8,.1)',  'color:#854d0e', 'Pendiente'],
                                'confirmada' => ['bg:rgba(34,197,94,.1)',  'color:#166534', 'Confirmada'],
                                'en_curso'   => ['bg:rgba(59,130,246,.1)', 'color:#1e40af', 'En curso'],
                                'completada' => ['bg:rgba(107,114,128,.1)','color:#374151', 'Completada'],
                                'cancelada'  => ['bg:rgba(239,68,68,.1)',  'color:#991b1b', 'Cancelada'],
                            ];
                            [$bg, $color, $label] = $badges[$r->estado] ?? ['bg:rgba(107,114,128,.1)','color:#374151',$r->estado];
                        @endphp
                        <tr style="border-bottom:1px solid rgba(201,170,113,.08)" class="hover:bg-amber-50/30">
                            <td class="p-4 font-serif text-base font-light" style="color:#1A3A5C">
                                #{{ $r->id }}
                            </td>
                            <td class="p-4">
                                <p class="font-medium text-sm" style="color:#1A3A5C">
                                    {{ $r->cliente->nombre }} {{ $r->cliente->apellido }}
                                </p>
                                <p class="text-[11px]" style="color:rgba(26,58,92,.45)">
                                    {{ $r->cliente->email }}
                                </p>
                            </td>
                            <td class="p-4">
                                <p class="text-sm" style="color:#1A3A5C">
                                    Nº {{ $r->habitacion->numero }}
                                </p>
                                <p class="text-[11px]" style="color:rgba(26,58,92,.45)">
                                    {{ $r->habitacion->tipo->nombre }} · Piso {{ $r->habitacion->piso }}
                                </p>
                            </td>
                            <td class="p-4 text-sm" style="color:rgba(26,58,92,.7)">
                                {{ \Carbon\Carbon::parse($r->fecha_ingreso)->format('d/m/Y') }}
                            </td>
                            <td class="p-4 font-medium text-sm" style="color:#1A3A5C">
                                S/ {{ number_format($r->total, 2) }}
                            </td>
                            <td class="p-4">
                                <span class="badge" style="{{ $bg }};{{ $color }}">
                                    {{ $label }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-sm" style="color:rgba(26,58,92,.4)">
                                <i class="fas fa-calendar-xmark mb-2 block text-2xl" style="color:rgba(201,170,113,.4)"></i>
                                No hay reservas registradas aún
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>
</div>
@endsection