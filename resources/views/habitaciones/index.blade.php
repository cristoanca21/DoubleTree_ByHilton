@extends('layouts.app')
@section('title', 'Habitaciones — DoubleTree by Hilton Trujillo')

@push('styles')
<style>
    /* ── Hero — misma corrección de contraste que welcome ── */
    .page-hero {
        position: relative;
        background-image:
            url('https://dynamic-media-cdn.tripadvisor.com/media/photo-o/2a/68/c1/e5/caption.jpg?w=1400&h=-1&s=1');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
    .page-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            linear-gradient(to bottom,
                rgba(8,18,32,0.72) 0%,
                rgba(8,18,32,0.58) 30%,
                rgba(8,18,32,0.66) 60%,
                rgba(8,18,32,0.88) 100%),
            radial-gradient(ellipse at center,
                rgba(8,18,32,0.25) 0%,
                rgba(8,18,32,0.55) 75%);
        pointer-events: none;
        z-index: 1;
    }
    .page-hero > * {
        position: relative;
        z-index: 2;
    }

    /* ── Buscador ── */
    .avail-bar {
        background: rgba(255,255,255,0.97);
        backdrop-filter: blur(8px);
        border-top: 3px solid #C9AA71;
        box-shadow: 0 4px 20px rgba(13,33,55,0.12);
    }
    .avail-input {
        width: 100%;
        border: 1px solid #D9C08F;
        background: #FAFAF8;
        color: #1A3A5C;
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        padding: 0.6rem 0.75rem;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .avail-input:focus {
        border-color: #1A3A5C;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(26,58,92,0.10);
    }

    /* ── Cards ── */
    .room-card {
        transition: transform 0.35s ease, box-shadow 0.35s ease;
        overflow: hidden;
    }
    .room-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 50px rgba(13,33,55,0.18);
    }
    .room-card img {
        transition: transform 0.5s ease;
    }
    .room-card:hover img {
        transform: scale(1.05);
    }

    /* ── Gold divider ── */
    .divider-gold {
        display: flex; align-items: center; gap: 0.75rem;
    }
    .divider-gold::before, .divider-gold::after {
        content: ''; flex: 1; height: 1px; background: #C9AA71; opacity: 0.40;
    }

    /* ── Reveal ── */
    .reveal {
        opacity: 0;
        transform: translateY(22px);
        transition: opacity 0.65s ease, transform 0.65s ease;
    }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    /* ── Fade up ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp 0.85s ease forwards; }
    .delay-1 { animation-delay: 0.15s; opacity: 0; }
    .delay-2 { animation-delay: 0.30s; opacity: 0; }
    .delay-3 { animation-delay: 0.45s; opacity: 0; }

    /* ── Empty state ── */
    .empty-state {
        border: 1px dashed #D9C08F;
        background: #FAFAF8;
    }

    /* ── Disponible badge ── */
    .badge-disponible {
        background: rgba(13,33,55,0.78);
        backdrop-filter: blur(4px);
        color: #fff;
        font-size: 9px;
        letter-spacing: .14em;
        text-transform: uppercase;
        padding: 4px 10px;
    }

    /* ── Filtro tipo activo ── */
    .tipo-pill {
        font-size: 9px;
        letter-spacing: .16em;
        text-transform: uppercase;
        padding: 6px 16px;
        border: 1px solid #D9C08F;
        color: #1A3A5C;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .tipo-pill:hover, .tipo-pill.active {
        background: #1A3A5C;
        color: #fff;
        border-color: #1A3A5C;
    }
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ --}}
<section class="page-hero relative flex items-center justify-center text-center px-6 pt-28 pb-20 min-h-[480px]">
    <div class="max-w-3xl">
        <p class="fade-up text-[9px] tracking-widest3 uppercase font-medium mb-4"
           style="color:#C9AA71;letter-spacing:.3em">
            Acomodaciones · Trujillo, Perú
        </p>
        <h1 class="fade-up delay-1 font-light leading-none"
            style="font-family:'Cormorant Garamond',Georgia,serif;color:#fff;font-size:clamp(2.8rem,7vw,5.5rem)">
            Nuestras <em style="font-style:italic;color:#C9AA71">Habitaciones</em>
        </h1>
        <p class="fade-up delay-2 font-light mt-6 leading-relaxed max-w-xl mx-auto"
           style="color:rgba(255,255,255,.68);font-size:.95rem">
            Descubra la calidez de nuestra hospitalidad en la Ciudad de la Eterna Primavera.
        </p>

        {{-- Stats --}}
        <div class="fade-up delay-3 flex items-center justify-center gap-0 mt-10 max-w-xs mx-auto divide-x"
             style="divide-color:rgba(255,255,255,.18)">
            @foreach([['147','Habitaciones'],['14','Pisos'],['3','Tipos']] as $s)
            <div class="flex-1 px-4">
                <div class="font-light" style="font-family:'Cormorant Garamond',Georgia,serif;color:#C9AA71;font-size:1.6rem">
                    {{ $s[0] }}
                </div>
                <div style="color:rgba(255,255,255,.50);font-size:8px;letter-spacing:.2em;text-transform:uppercase;margin-top:2px">
                    {{ $s[1] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Scroll cue --}}
    <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1.5"
         style="opacity:.55">
        <span style="color:#fff;font-size:8px;letter-spacing:.2em;text-transform:uppercase">Deslizar</span>
        <div style="width:1px;height:28px;background:#C9AA71;animation:bounce 1.4s infinite"></div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     BUSCADOR STICKY
══════════════════════════════════════════ --}}
<div id="buscador" class="avail-bar sticky top-[72px] z-30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5">
        <form action="{{ route('habitaciones.index') }}" method="GET"
              class="flex flex-col lg:flex-row items-end gap-3">

            <div class="w-full lg:flex-1 grid grid-cols-2 lg:grid-cols-4 gap-3">

                {{-- Tipo --}}
                <div>
                    <label class="block mb-1.5"
                           style="font-size:9px;letter-spacing:.18em;text-transform:uppercase;color:rgba(26,58,92,.55);font-weight:500">
                        Tipo de Habitación
                    </label>
                    <select name="tipo_id" class="avail-input">
                        <option value="">Cualquier tipo</option>
                        @foreach($tipos as $tipo)
                            <option value="{{ $tipo->id }}"
                                {{ request('tipo_id') == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nombre }} · S/ {{ number_format($tipo->precio_noche, 0) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Check-in --}}
                <div>
                    <label class="block mb-1.5"
                           style="font-size:9px;letter-spacing:.18em;text-transform:uppercase;color:rgba(26,58,92,.55);font-weight:500">
                        Check-in
                    </label>
                    <input type="datetime-local" name="fecha_ingreso"
                           value="{{ request('fecha_ingreso') }}"
                           class="avail-input">
                </div>

                {{-- Check-out --}}
                <div>
                    <label class="block mb-1.5"
                           style="font-size:9px;letter-spacing:.18em;text-transform:uppercase;color:rgba(26,58,92,.55);font-weight:500">
                        Check-out
                    </label>
                    <input type="datetime-local" name="fecha_salida"
                           value="{{ request('fecha_salida') }}"
                           class="avail-input">
                </div>

                {{-- Huéspedes --}}
                <div>
                    <label class="block mb-1.5"
                           style="font-size:9px;letter-spacing:.18em;text-transform:uppercase;color:rgba(26,58,92,.55);font-weight:500">
                        Huéspedes
                    </label>
                    <select name="huespedes" class="avail-input">
                        @foreach([1,2,3,4] as $n)
                            <option value="{{ $n }}"
                                {{ request('huespedes', 2) == $n ? 'selected' : '' }}>
                                {{ $n }} {{ $n == 1 ? 'Huésped' : 'Huéspedes' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex gap-2 w-full lg:w-auto flex-shrink-0">
                <button type="submit"
                        class="flex-1 lg:flex-none whitespace-nowrap text-white font-semibold px-7 py-2.5 transition-all duration-200 hover:shadow-lg"
                        style="background:#1A3A5C;font-size:9px;letter-spacing:.18em;text-transform:uppercase;border:none;cursor:pointer">
                    <i class="fas fa-search mr-1.5" style="color:rgba(201,170,113,.85)"></i>Buscar
                </button>
                @if(request()->hasAny(['tipo_id','fecha_ingreso','fecha_salida','huespedes']))
                <a href="{{ route('habitaciones.index') }}"
                   class="px-3.5 py-2.5 flex items-center justify-center transition-all duration-200 hover:opacity-80"
                   style="border:1px solid #D9C08F;color:#1A3A5C;text-decoration:none"
                   title="Limpiar filtros">
                    <i class="fas fa-times text-xs"></i>
                </a>
                @endif
            </div>
        </form>
    </div>
</div>


{{-- ══════════════════════════════════════════
     VISTA: TIPOS DESTACADOS (sin filtros)
══════════════════════════════════════════ --}}
@if(!request()->hasAny(['tipo_id','fecha_ingreso','fecha_salida','huespedes']))

<section class="py-24 lg:py-32" style="background:#F8F5EF">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        {{-- Header sección --}}
        <div class="text-center mb-16 reveal">
            <p style="color:#C9AA71;font-size:9px;letter-spacing:.3em;text-transform:uppercase;font-weight:500;margin-bottom:10px">
                Elige tu estancia
            </p>
            <h2 class="font-light" style="font-family:'Cormorant Garamond',Georgia,serif;color:#1A3A5C;font-size:clamp(2rem,5vw,3.2rem)">
                Tipos de Habitación
            </h2>
            <div class="divider-gold max-w-xs mx-auto mt-5">
                <i class="fas fa-star" style="color:#C9AA71;font-size:8px"></i>
            </div>
            <p class="font-light mt-5 max-w-lg mx-auto leading-relaxed"
               style="color:rgba(26,58,92,.58);font-size:.875rem">
                Selecciona el tipo de habitación que mejor se adapte a tus necesidades
                o usa el buscador para verificar disponibilidad por fechas específicas.
            </p>
        </div>

        {{-- Cards de tipos --}}
        @php
        $imagenes = [
            'Matrimonial' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=800&q=80',
            'Doble'       => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=800&q=80',
            'Suite'       => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=800&q=80',
        ];
        $amenidades = [
            'Matrimonial' => ['King Size','Baño Privado','WiFi','AC','TV 55"'],
            'Doble'       => ['2 Camas','Escritorio','WiFi','AC','Minibar'],
            'Suite'       => ['Sala Privada','Jacuzzi','Mayordomo','Vista Premium','Desayuno'],
        ];
        $badges = [
            'Matrimonial' => null,
            'Doble'       => 'Más Elegida',
            'Suite'       => 'Premium',
        ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
            @foreach($tipos as $i => $tipo)
            @php
                $esDestacada = $tipo->nombre === 'Doble';
                $img   = $imagenes[$tipo->nombre]  ?? $imagenes['Matrimonial'];
                $ams   = $amenidades[$tipo->nombre] ?? [];
                $badge = $badges[$tipo->nombre]     ?? null;
            @endphp

            <div class="room-card reveal {{ $esDestacada ? 'md:-mt-6 md:shadow-2xl' : '' }}"
                 style="background:{{ $esDestacada ? '#1A3A5C' : '#fff' }};transition-delay:{{ $i * 0.1 }}s">

                {{-- Imagen --}}
                <div class="overflow-hidden relative" style="height:260px">
                    <img src="{{ $img }}" alt="{{ $tipo->nombre }}"
                         class="w-full h-full object-cover">
                    @if($badge)
                    <div class="absolute top-4 left-4 font-semibold"
                         style="background:#C9AA71;color:#0D2137;font-size:9px;letter-spacing:.16em;text-transform:uppercase;padding:5px 12px">
                        {{ $badge }}
                    </div>
                    @endif
                    {{-- Precio flotante --}}
                    <div class="absolute bottom-0 right-0 px-4 py-2.5"
                         style="background:rgba(13,33,55,.82);backdrop-filter:blur(4px)">
                        <div style="font-family:'Cormorant Garamond',Georgia,serif;color:#C9AA71;font-size:1.25rem;font-weight:300;line-height:1">
                            S/ {{ number_format($tipo->precio_noche, 0) }}
                        </div>
                        <div style="color:rgba(255,255,255,.5);font-size:8px;letter-spacing:.12em;text-transform:uppercase">
                            por noche
                        </div>
                    </div>
                </div>

                {{-- Cuerpo --}}
                <div class="p-7">
                    <p style="color:#C9AA71;font-size:9px;letter-spacing:.22em;text-transform:uppercase;font-weight:500;margin-bottom:4px">
                        {{ $tipo->capacidad <= 2 ? 'Habitación' : 'Suite Premium' }}
                        · Hasta {{ $tipo->capacidad }} pers.
                    </p>
                    <h3 class="font-light mb-3"
                        style="font-family:'Cormorant Garamond',Georgia,serif;
                               color:{{ $esDestacada ? '#fff' : '#1A3A5C' }};
                               font-size:1.6rem">
                        {{ $tipo->nombre }}
                    </h3>

                    <p class="leading-relaxed mb-5"
                       style="font-size:.82rem;color:{{ $esDestacada ? 'rgba(255,255,255,.62)' : 'rgba(26,58,92,.62)' }}">
                        {{ $tipo->descripcion }}
                    </p>

                    {{-- Amenidades --}}
                    <ul class="flex flex-wrap gap-1.5 mb-6">
                        @foreach($ams as $amenity)
                        <li style="font-size:8px;letter-spacing:.12em;text-transform:uppercase;
                                   background:{{ $esDestacada ? '#0D2137' : '#F8F5EF' }};
                                   color:{{ $esDestacada ? 'rgba(255,255,255,.65)' : 'rgba(26,58,92,.7)' }};
                                   border:1px solid {{ $esDestacada ? 'rgba(201,170,113,.2)' : 'rgba(201,170,113,.3)' }};
                                   padding:3px 8px">
                            {{ $amenity }}
                        </li>
                        @endforeach
                    </ul>

                    {{-- CTA --}}
                    <a href="{{ route('habitaciones.index', ['tipo_id' => $tipo->id]) }}"
                       style="display:block;text-align:center;text-decoration:none;
                              font-size:9px;letter-spacing:.18em;text-transform:uppercase;font-weight:600;
                              padding:12px;transition:all .2s;
                              {{ $esDestacada
                                  ? 'background:#C9AA71;color:#0D2137;'
                                  : 'border:1px solid #1A3A5C;color:#1A3A5C;' }}">
                        Ver Disponibilidad →
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Info complementaria --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-px mt-16 reveal"
             style="background:rgba(201,170,113,.2)">
            @foreach([
                ['fa-wifi',        'WiFi de Alta Velocidad',    'Conectividad total en todas las habitaciones y áreas comunes.'],
                ['fa-concierge-bell','Servicio 24/7',           'Recepción y atención al huésped disponible a cualquier hora.'],
                ['fa-shield-halved','Cancelación Flexible',     'Modifica o cancela tu reserva sin penalidad con 48 h de anticipación.'],
            ] as [$icon, $title, $desc])
            <div class="reveal py-8 px-8 text-center" style="background:#fff">
                <i class="fas {{ $icon }} mb-4 block" style="color:#C9AA71;font-size:1.25rem"></i>
                <h4 class="font-light mb-2"
                    style="font-family:'Cormorant Garamond',Georgia,serif;color:#1A3A5C;font-size:1.1rem">
                    {{ $title }}
                </h4>
                <p style="font-size:.78rem;color:rgba(26,58,92,.55);line-height:1.6">{{ $desc }}</p>
            </div>
            @endforeach
        </div>

    </div>
</section>

@endif {{-- fin sin filtros --}}


{{-- ══════════════════════════════════════════
     VISTA: RESULTADOS DE BÚSQUEDA (con filtros)
══════════════════════════════════════════ --}}
@if(request()->hasAny(['tipo_id','fecha_ingreso','fecha_salida','huespedes']))

<section class="py-16" style="background:#F8F5EF">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        {{-- Header resultados --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10 reveal">
            <div>
                <p style="color:#C9AA71;font-size:9px;letter-spacing:.28em;text-transform:uppercase;font-weight:500;margin-bottom:6px">
                    Resultados de búsqueda
                </p>
                <h2 class="font-light" style="font-family:'Cormorant Garamond',Georgia,serif;color:#1A3A5C;font-size:2rem">
                    <span style="font-size:2.4rem">{{ $habitaciones->count() }}</span>
                    {{ $habitaciones->count() == 1 ? 'habitación disponible' : 'habitaciones disponibles' }}
                </h2>
                @if(request('fecha_ingreso') && request('fecha_salida'))
                <p style="color:rgba(26,58,92,.5);font-size:.78rem;margin-top:4px">
                    <i class="fas fa-calendar-alt mr-1.5" style="color:#C9AA71"></i>
                    {{ \Carbon\Carbon::parse(request('fecha_ingreso'))->format('d M') }}
                    →
                    {{ \Carbon\Carbon::parse(request('fecha_salida'))->format('d M Y') }}
                    @php
                        $noches = \Carbon\Carbon::parse(request('fecha_ingreso'))->diffInDays(\Carbon\Carbon::parse(request('fecha_salida')));
                    @endphp
                    @if($noches > 0)
                    · {{ $noches }} {{ $noches == 1 ? 'noche' : 'noches' }}
                    @endif
                </p>
                @endif
            </div>
            <div class="flex items-center gap-3">
                {{-- Pills de tipo --}}
                <div class="flex gap-2 flex-wrap">
                    <a href="{{ route('habitaciones.index', array_merge(request()->except('tipo_id'), [])) }}"
                       class="tipo-pill {{ !request('tipo_id') ? 'active' : '' }}"
                       style="text-decoration:none">
                        Todos
                    </a>
                    @foreach($tipos as $tipo)
                    <a href="{{ route('habitaciones.index', array_merge(request()->all(), ['tipo_id' => $tipo->id])) }}"
                       class="tipo-pill {{ request('tipo_id') == $tipo->id ? 'active' : '' }}"
                       style="text-decoration:none">
                        {{ $tipo->nombre }}
                    </a>
                    @endforeach
                </div>
                <a href="{{ route('habitaciones.index') }}"
                   style="color:rgba(26,58,92,.55);font-size:9px;letter-spacing:.16em;text-transform:uppercase;text-decoration:none;border-bottom:1px solid #D9C08F;padding-bottom:1px;white-space:nowrap">
                    <i class="fas fa-arrow-left text-[9px] mr-1"></i>Ver todas
                </a>
            </div>
        </div>

        @if($habitaciones->isEmpty())
        {{-- ── Sin resultados ── --}}
        <div class="empty-state p-16 text-center reveal">
            <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center"
                 style="background:rgba(201,170,113,.12);border:1px solid rgba(201,170,113,.25)">
                <i class="fas fa-bed" style="color:rgba(201,170,113,.5);font-size:1.5rem"></i>
            </div>
            <h3 class="font-light mb-3"
                style="font-family:'Cormorant Garamond',Georgia,serif;color:#1A3A5C;font-size:1.7rem">
                Sin disponibilidad para esas fechas
            </h3>
            <p class="mb-7 max-w-sm mx-auto"
               style="color:rgba(26,58,92,.55);font-size:.85rem;line-height:1.7">
                Prueba con otras fechas o un tipo de habitación diferente.
                Nuestro equipo también puede ayudarte por teléfono.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('habitaciones.index') }}"
                   style="background:#1A3A5C;color:#fff;text-decoration:none;
                          font-size:9px;letter-spacing:.18em;text-transform:uppercase;font-weight:600;
                          padding:12px 28px;display:inline-block">
                    Buscar de nuevo
                </a>
                <a href="tel:+5144123456"
                   style="border:1px solid #D9C08F;color:#1A3A5C;text-decoration:none;
                          font-size:9px;letter-spacing:.18em;text-transform:uppercase;
                          padding:11px 28px;display:inline-block">
                    <i class="fas fa-phone mr-2" style="color:#C9AA71"></i>(044) 123-456
                </a>
            </div>
        </div>

        @else
        {{-- ── Grid de habitaciones ── --}}
        @php $imagenes ??= [
            'Matrimonial' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=800&q=80',
            'Doble'       => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=800&q=80',
            'Suite'       => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=800&q=80',
        ]; @endphp

        @php
            $noches = request('fecha_ingreso') && request('fecha_salida')
                ? \Carbon\Carbon::parse(request('fecha_ingreso'))->diffInDays(\Carbon\Carbon::parse(request('fecha_salida')))
                : 1;
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($habitaciones as $i => $hab)
            @php
                $img = $imagenes[$hab->tipo->nombre] ?? $imagenes['Matrimonial'];
            @endphp

            <div class="room-card bg-white reveal" style="transition-delay:{{ ($i % 6) * 0.07 }}s">

                {{-- Imagen --}}
                <div class="overflow-hidden relative" style="height:200px">
                    <img src="{{ $img }}" alt="Habitación {{ $hab->numero }}"
                         class="w-full h-full object-cover">

                    {{-- Piso / número --}}
                    <div class="absolute top-3 left-3 badge-disponible">
                        Piso {{ $hab->piso }} · Nº {{ $hab->numero }}
                    </div>

                    {{-- Disponible --}}
                    <div class="absolute top-3 right-3"
                         style="background:#16a34a;color:#fff;font-size:8px;letter-spacing:.14em;text-transform:uppercase;padding:4px 9px">
                        Disponible
                    </div>

                    {{-- Precio sobre imagen (noches) --}}
                    @if($noches > 1)
                    <div class="absolute bottom-0 left-0 right-0 px-4 py-2 flex items-center justify-between"
                         style="background:linear-gradient(transparent,rgba(13,33,55,.75))">
                        <span style="color:rgba(255,255,255,.7);font-size:9px;letter-spacing:.1em;text-transform:uppercase">
                            {{ $noches }} noches
                        </span>
                        <span style="font-family:'Cormorant Garamond',Georgia,serif;color:#C9AA71;font-size:1rem;font-weight:300">
                            S/ {{ number_format($hab->tipo->precio_noche * $noches, 0) }} total
                        </span>
                    </div>
                    @endif
                </div>

                {{-- Cuerpo --}}
                <div class="p-5">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <p style="color:#C9AA71;font-size:8px;letter-spacing:.2em;text-transform:uppercase;font-weight:500;margin-bottom:2px">
                                {{ $hab->tipo->nombre }}
                            </p>
                            <h3 class="font-light"
                                style="font-family:'Cormorant Garamond',Georgia,serif;color:#1A3A5C;font-size:1.3rem">
                                Habitación {{ $hab->numero }}
                            </h3>
                        </div>
                        <div class="text-right">
                            <div class="font-light"
                                 style="font-family:'Cormorant Garamond',Georgia,serif;color:#1A3A5C;font-size:1.3rem">
                                S/ {{ number_format($hab->tipo->precio_noche, 0) }}
                            </div>
                            <div style="color:rgba(26,58,92,.4);font-size:8px;letter-spacing:.1em">/ noche</div>
                        </div>
                    </div>

                    <p class="mb-4 line-clamp-2"
                       style="color:rgba(26,58,92,.58);font-size:.78rem;line-height:1.6">
                        {{ $hab->tipo->descripcion }}
                    </p>

                    {{-- Info rápida --}}
                    <div class="flex items-center gap-4 mb-5"
                         style="font-size:.72rem;color:rgba(26,58,92,.5)">
                        <span>
                            <i class="fas fa-users mr-1" style="color:#C9AA71"></i>
                            {{ $hab->tipo->capacidad }} {{ $hab->tipo->capacidad == 1 ? 'persona' : 'personas' }}
                        </span>
                        <span><i class="fas fa-wifi mr-1" style="color:#C9AA71"></i>WiFi</span>
                        <span><i class="fas fa-snowflake mr-1" style="color:#C9AA71"></i>AC</span>
                        <span><i class="fas fa-tv mr-1" style="color:#C9AA71"></i>TV</span>
                    </div>

                    {{-- Botón reservar --}}
                    <a href="{{ route('reservas.create', [
                            'habitacion_id' => $hab->id,
                            'fecha_ingreso' => request('fecha_ingreso'),
                            'fecha_salida'  => request('fecha_salida'),
                        ]) }}"
                       style="display:block;text-align:center;text-decoration:none;
                              background:#1A3A5C;color:#fff;
                              font-size:9px;letter-spacing:.18em;text-transform:uppercase;font-weight:600;
                              padding:11px;transition:all .2s"
                       onmouseover="this.style.background='#0D2137'"
                       onmouseout="this.style.background='#1A3A5C'">
                        <i class="fas fa-calendar-check mr-2" style="color:rgba(201,170,113,.8)"></i>
                        Reservar esta habitación
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Resumen total si hay noches --}}
        @if($noches > 1 && $habitaciones->count() > 0)
        <div class="text-center mt-8 reveal">
            <p style="color:rgba(26,58,92,.5);font-size:.78rem">
                Precios mostrados para
                <strong style="color:#1A3A5C">{{ $noches }} {{ $noches == 1 ? 'noche' : 'noches' }}</strong>.
                El total final se calcula al confirmar la reserva.
            </p>
        </div>
        @endif

        @endif {{-- fin isEmpty --}}

    </div>
</section>

@endif {{-- fin con filtros --}}


{{-- ══════════════════════════════════════════
     CTA BANNER
══════════════════════════════════════════ --}}
<section style="background:#C9AA71;padding:4rem 1.5rem">
    <div class="max-w-3xl mx-auto text-center reveal">
        <p style="color:rgba(13,33,55,.6);font-size:8px;letter-spacing:.3em;text-transform:uppercase;margin-bottom:8px;font-weight:500">
            Reserva Directa
        </p>
        <h2 class="font-light mb-4"
            style="font-family:'Cormorant Garamond',Georgia,serif;color:#0D2137;font-size:clamp(1.7rem,4vw,2.5rem)">
            Mejor precio garantizado<br>
            <em>al reservar directamente</em>
        </h2>
        <p class="mb-8 max-w-md mx-auto" style="color:rgba(13,33,55,.62);font-size:.85rem;line-height:1.7">
            Sin intermediarios ni comisiones. Accede a beneficios exclusivos y atención personalizada.
        </p>
        @guest('cliente')
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('registro') }}"
               style="background:#1A3A5C;color:#fff;text-decoration:none;
                      font-size:9px;letter-spacing:.18em;text-transform:uppercase;font-weight:600;
                      padding:14px 32px;display:inline-block;transition:all .2s"
               onmouseover="this.style.background='#0D2137'"
               onmouseout="this.style.background='#1A3A5C'">
                Crear Cuenta Gratis
            </a>
            <a href="{{ route('login') }}"
               style="border:2px solid #0D2137;color:#0D2137;text-decoration:none;
                      font-size:9px;letter-spacing:.18em;text-transform:uppercase;
                      padding:12px 32px;display:inline-block;transition:all .2s"
               onmouseover="this.style.background='rgba(13,33,55,.08)'"
               onmouseout="this.style.background='transparent'">
                Iniciar Sesión
            </a>
        </div>
        @else
        <a href="{{ route('reservas.index') }}"
           style="background:#1A3A5C;color:#fff;text-decoration:none;
                  font-size:9px;letter-spacing:.18em;text-transform:uppercase;font-weight:600;
                  padding:14px 32px;display:inline-block">
            Ver mis Reservas
        </a>
        @endguest
    </div>
</section>

@endsection

@push('page-scripts')
<script>
/* Scroll reveal */
const revealEls = document.querySelectorAll('.reveal');
const obs = new IntersectionObserver((entries) => {
    entries.forEach(el => {
        if (el.isIntersecting) {
            el.target.classList.add('visible');
            obs.unobserve(el.target);
        }
    });
}, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
revealEls.forEach(el => obs.observe(el));

/* Auto-ajuste checkout cuando cambia check-in */
const fi = document.querySelector('input[name="fecha_ingreso"]');
const fs = document.querySelector('input[name="fecha_salida"]');
if (fi && fs) {
    fi.addEventListener('change', () => {
        if (!fs.value || fs.value <= fi.value) {
            const d = new Date(fi.value);
            d.setDate(d.getDate() + 1);
            fs.value = d.toISOString().slice(0, 16);
        }
        fs.min = fi.value;
    });
}
</script>
@endpush