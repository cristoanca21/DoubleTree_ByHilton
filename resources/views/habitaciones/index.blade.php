@extends('layouts.app')
@section('title', 'Habitaciones — DoubleTree by Hilton Trujillo')

@section('content')

{{-- ══════════════════════════════════════════
     HEAD STYLES (mismo estilo que welcome)
══════════════════════════════════════════ --}}
<style>
    body { font-family: 'Inter', sans-serif; background: #F8F5EF; color: #1A3A5C; }

    .divider-gold {
        display: flex; align-items: center; gap: 0.75rem;
    }
    .divider-gold::before, .divider-gold::after {
        content: ''; flex: 1; height: 1px; background: #C9AA71; opacity: 0.45;
    }

    /* Hero */
    .page-hero {
        background-image:
            linear-gradient(to bottom, rgba(13,33,55,0.65) 0%, rgba(13,33,55,0.45) 50%, rgba(13,33,55,0.80) 100%),
            url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=85');
        background-size: cover;
        background-position: center;
    }

    /* Search bar */
    .avail-bar {
        background: rgba(255,255,255,0.97);
        backdrop-filter: blur(8px);
        border-top: 3px solid #C9AA71;
    }
    .avail-input {
        border: 1px solid #D9C08F;
        background: #FAFAF8;
        color: #1A3A5C;
        font-family: 'Inter', sans-serif;
        font-size: 0.875rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .avail-input:focus {
        outline: none;
        border-color: #1A3A5C;
        box-shadow: 0 0 0 3px rgba(26,58,92,0.12);
    }

    /* Room cards */
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
        transform: scale(1.04);
    }

    /* Reveal animation */
    .reveal { opacity: 0; transform: translateY(24px); transition: opacity 0.7s ease, transform 0.7s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(28px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp 0.9s ease forwards; }
    .delay-1 { animation-delay: 0.15s; opacity: 0; }
    .delay-2 { animation-delay: 0.30s; opacity: 0; }

    /* Tipo tabs */
    .tipo-tab { transition: all 0.2s; cursor: pointer; }
    .tipo-tab.active {
        background: #1A3A5C;
        color: #fff;
        border-color: #1A3A5C;
    }

    /* Empty state */
    .empty-state {
        border: 1px dashed #D9C08F;
        background: #FAFAF8;
    }
</style>

{{-- ══════════════════════════════════════════
     HERO
══════════════════════════════════════════ --}}
<section class="page-hero relative flex items-center justify-center text-center px-6 pt-32 pb-24 min-h-[420px]">
    <div class="max-w-3xl">
        <p class="fade-up text-gold text-[10px] tracking-widest uppercase font-medium mb-4"
           style="color:#C9AA71">
            Acomodaciones · Trujillo, Perú
        </p>
        <h1 class="fade-up delay-1 font-serif text-white font-light leading-none text-4xl sm:text-6xl lg:text-7xl"
            style="font-family:'Cormorant Garamond',Georgia,serif">
            Nuestras <em class="italic" style="color:#C9AA71">Habitaciones</em>
        </h1>
        <p class="fade-up delay-2 text-white/70 text-base font-light mt-6 leading-relaxed max-w-xl mx-auto">
            147 habitaciones distribuidas en 14 pisos, diseñadas para ofrecerte
            descanso absoluto con los más altos estándares de confort.
        </p>

        {{-- Stats --}}
        <div class="fade-up delay-2 grid grid-cols-3 gap-6 max-w-sm mx-auto mt-10">
            @foreach([['147','Habitaciones'],['14','Pisos'],['3','Tipos']] as $s)
            <div>
                <div class="font-serif text-2xl font-light" style="color:#C9AA71;font-family:'Cormorant Garamond',Georgia,serif">{{ $s[0] }}</div>
                <div class="text-white/55 text-[10px] tracking-widest uppercase mt-0.5">{{ $s[1] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     BUSCADOR
══════════════════════════════════════════ --}}
<div id="buscador" class="avail-bar sticky top-0 z-40 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <form action="{{ route('habitaciones.index') }}" method="GET"
              class="flex flex-col lg:flex-row items-center gap-3 lg:gap-4">

            <div class="w-full lg:flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

                {{-- Tipo --}}
                <div class="flex flex-col">
                    <label class="text-[10px] tracking-widest uppercase font-medium mb-1 ml-1"
                           style="color:rgba(26,58,92,.6)">Tipo de Habitación</label>
                    <select name="tipo_id" class="avail-input rounded px-3 py-2.5">
                        <option value="">Cualquier tipo</option>
                        @foreach($tipos as $tipo)
                            <option value="{{ $tipo->id }}"
                                {{ request('tipo_id') == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nombre }} · S/ {{ number_format($tipo->precio_noche,2) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Fecha ingreso --}}
                <div class="flex flex-col">
                    <label class="text-[10px] tracking-widest uppercase font-medium mb-1 ml-1"
                           style="color:rgba(26,58,92,.6)">Check-in</label>
                    <input type="datetime-local" name="fecha_ingreso"
                           value="{{ request('fecha_ingreso') }}"
                           class="avail-input rounded px-3 py-2.5">
                </div>

                {{-- Fecha salida --}}
                <div class="flex flex-col">
                    <label class="text-[10px] tracking-widest uppercase font-medium mb-1 ml-1"
                           style="color:rgba(26,58,92,.6)">Check-out</label>
                    <input type="datetime-local" name="fecha_salida"
                           value="{{ request('fecha_salida') }}"
                           class="avail-input rounded px-3 py-2.5">
                </div>

                {{-- Huéspedes --}}
                <div class="flex flex-col">
                    <label class="text-[10px] tracking-widest uppercase font-medium mb-1 ml-1"
                           style="color:rgba(26,58,92,.6)">Huéspedes</label>
                    <select name="huespedes" class="avail-input rounded px-3 py-2.5">
                        @foreach([1,2,3,4] as $n)
                            <option value="{{ $n }}" {{ request('huespedes',2) == $n ? 'selected':'' }}>
                                {{ $n }} {{ $n == 1 ? 'Huésped' : 'Huéspedes' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex gap-2 w-full lg:w-auto mt-1 lg:mt-4">
                <button type="submit"
                        class="flex-1 lg:flex-none whitespace-nowrap text-white text-xs tracking-widest uppercase font-semibold px-8 py-3 transition-all duration-200 hover:shadow-lg"
                        style="background:#1A3A5C">
                    <i class="fas fa-search mr-2" style="color:rgba(201,170,113,.8)"></i>Buscar
                </button>
                @if(request()->hasAny(['tipo_id','fecha_ingreso','fecha_salida','huespedes']))
                    <a href="{{ route('habitaciones.index') }}"
                       class="px-4 py-3 border text-xs tracking-widest uppercase transition-all duration-200 flex items-center"
                       style="border-color:#D9C08F;color:#1A3A5C">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- ══════════════════════════════════════════
     TIPOS DESTACADOS (siempre visible)
══════════════════════════════════════════ --}}
@if(!request()->hasAny(['tipo_id','fecha_ingreso','fecha_salida','huespedes']))
<section class="py-24 lg:py-32" style="background:#F8F5EF">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="text-center mb-16 reveal">
            <p class="text-[10px] tracking-widest uppercase font-medium mb-3" style="color:#C9AA71">
                Elige tu estancia
            </p>
            <h2 class="font-serif text-4xl sm:text-5xl font-light" style="font-family:'Cormorant Garamond',Georgia,serif;color:#1A3A5C">
                Tipos de Habitación
            </h2>
            <div class="divider-gold max-w-xs mx-auto mt-5">
                <i class="fas fa-star text-xs" style="color:#C9AA71"></i>
            </div>
            <p class="text-sm font-light mt-5 max-w-lg mx-auto leading-relaxed" style="color:rgba(26,58,92,.6)">
                Selecciona el tipo de habitación que mejor se adapte a tus necesidades
                o usa el buscador para verificar disponibilidad por fechas.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

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

            @foreach($tipos as $i => $tipo)
            @php
                $esDestacada = $tipo->nombre === 'Doble';
                $img = $imagenes[$tipo->nombre] ?? 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=800&q=80';
                $ams = $amenidades[$tipo->nombre] ?? [];
                $badge = $badges[$tipo->nombre] ?? null;
            @endphp

            <div class="room-card reveal {{ $esDestacada ? 'md:-mt-4' : '' }}"
                 style="transition-delay:{{ $i * 0.1 }}s;background:{{ $esDestacada ? '#1A3A5C' : '#fff' }}">

                <div class="overflow-hidden h-64 relative">
                    <img src="{{ $img }}" alt="{{ $tipo->nombre }}"
                         class="w-full h-full object-cover">
                    @if($badge)
                    <div class="absolute top-4 left-4 text-[10px] tracking-widest uppercase font-semibold px-3 py-1.5"
                         style="background:#C9AA71;color:#0D2137">
                        {{ $badge }}
                    </div>
                    @endif
                </div>

                <div class="p-7">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <p class="text-[10px] tracking-widest uppercase font-medium mb-1"
                               style="color:#C9AA71">
                                {{ $tipo->capacidad <= 2 ? 'Habitación' : ($tipo->nombre === 'Suite' ? 'Suite Premium' : 'Habitación') }}
                            </p>
                            <h3 class="font-serif text-2xl font-light"
                                style="font-family:'Cormorant Garamond',Georgia,serif;color:{{ $esDestacada ? '#fff' : '#1A3A5C' }}">
                                {{ $tipo->nombre }}
                            </h3>
                        </div>
                        <div class="text-right">
                            <span class="text-xs" style="color:{{ $esDestacada ? 'rgba(255,255,255,.4)' : 'rgba(26,58,92,.4)' }}">Desde</span>
                            <div class="font-serif text-2xl font-light"
                                 style="font-family:'Cormorant Garamond',Georgia,serif;color:{{ $esDestacada ? '#C9AA71' : '#1A3A5C' }}">
                                S/ {{ number_format($tipo->precio_noche, 2) }}
                            </div>
                            <span class="text-[10px]" style="color:{{ $esDestacada ? 'rgba(255,255,255,.4)' : 'rgba(26,58,92,.4)' }}">
                                por noche
                            </span>
                        </div>
                    </div>

                    <p class="text-sm leading-relaxed mb-5"
                       style="color:{{ $esDestacada ? 'rgba(255,255,255,.65)' : 'rgba(26,58,92,.6)' }}">
                        {{ $tipo->descripcion }}
                    </p>

                    <ul class="flex flex-wrap gap-2 mb-6">
                        @foreach($ams as $amenity)
                        <li class="text-[10px] tracking-wide uppercase px-2.5 py-1"
                            style="background:{{ $esDestacada ? '#0D2137' : '#F8F5EF' }};
                                   color:{{ $esDestacada ? 'rgba(255,255,255,.7)' : 'rgba(26,58,92,.7)' }};
                                   border:1px solid {{ $esDestacada ? 'rgba(201,170,113,.2)' : 'rgba(201,170,113,.25)' }}">
                            {{ $amenity }}
                        </li>
                        @endforeach
                        <li class="text-[10px] tracking-wide uppercase px-2.5 py-1"
                            style="background:{{ $esDestacada ? '#0D2137' : '#F8F5EF' }};
                                   color:{{ $esDestacada ? 'rgba(255,255,255,.7)' : 'rgba(26,58,92,.7)' }};
                                   border:1px solid {{ $esDestacada ? 'rgba(201,170,113,.2)' : 'rgba(201,170,113,.25)' }}">
                            Hasta {{ $tipo->capacidad }} pers.
                        </li>
                    </ul>

                    <a href="{{ route('habitaciones.index', ['tipo_id' => $tipo->id]) }}"
                       class="block text-center text-xs tracking-widest uppercase font-semibold py-3 transition-all duration-200"
                       style="{{ $esDestacada
                           ? 'background:#C9AA71;color:#0D2137;'
                           : 'border:1px solid #1A3A5C;color:#1A3A5C;' }}
                              display:block;text-decoration:none">
                        Ver Disponibilidad
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════
     RESULTADOS DE BÚSQUEDA
══════════════════════════════════════════ --}}
@if(request()->hasAny(['tipo_id','fecha_ingreso','fecha_salida','huespedes']))
<section class="py-16" style="background:#F8F5EF">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        {{-- Header resultados --}}
        <div class="flex items-end justify-between mb-10 reveal">
            <div>
                <p class="text-[10px] tracking-widest uppercase font-medium mb-1" style="color:#C9AA71">
                    Resultados de búsqueda
                </p>
                <h2 class="font-serif text-3xl font-light" style="font-family:'Cormorant Garamond',Georgia,serif;color:#1A3A5C">
                    <span class="text-4xl font-light" style="color:#1A3A5C">{{ $habitaciones->count() }}</span>
                    {{ $habitaciones->count() == 1 ? 'habitación disponible' : 'habitaciones disponibles' }}
                </h2>
            </div>
            <a href="{{ route('habitaciones.index') }}"
               class="text-xs tracking-widest uppercase transition-colors duration-200 pb-0.5"
               style="color:#1A3A5C;border-bottom:1px solid #C9AA71">
                <i class="fas fa-arrow-left mr-2 text-[10px]"></i>Ver todas
            </a>
        </div>

        @if($habitaciones->isEmpty())
        {{-- Sin resultados --}}
        <div class="empty-state rounded-none p-16 text-center reveal">
            <i class="fas fa-bed text-4xl mb-5 block" style="color:rgba(201,170,113,.4)"></i>
            <h3 class="font-serif text-2xl font-light mb-3" style="font-family:'Cormorant Garamond',Georgia,serif;color:#1A3A5C">
                Sin disponibilidad para esas fechas
            </h3>
            <p class="text-sm mb-6 max-w-sm mx-auto" style="color:rgba(26,58,92,.6)">
                Prueba con otras fechas o un tipo de habitación diferente.
            </p>
            <a href="{{ route('habitaciones.index') }}"
               class="inline-block text-white text-xs tracking-widest uppercase font-semibold px-8 py-3 transition-all duration-200"
               style="background:#1A3A5C">
                Buscar de nuevo
            </a>
        </div>

        @else
        {{-- Grid de habitaciones --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($habitaciones as $i => $hab)
            @php
                $img = $imagenes[$hab->tipo->nombre] ?? 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=800&q=80';
            @endphp
            <div class="room-card bg-white reveal" style="transition-delay:{{ ($i % 6) * 0.07 }}s">

                <div class="overflow-hidden h-48 relative">
                    <img src="{{ $img }}" alt="Habitación {{ $hab->numero }}"
                         class="w-full h-full object-cover">
                    <div class="absolute top-3 left-3 text-[10px] tracking-wide uppercase font-medium px-2.5 py-1"
                         style="background:rgba(13,33,55,.75);color:#fff;backdrop-filter:blur(4px)">
                        Piso {{ $hab->piso }} · Nº {{ $hab->numero }}
                    </div>
                    <div class="absolute top-3 right-3 text-[10px] font-semibold px-2.5 py-1"
                         style="background:#22c55e;color:#fff">
                        Disponible
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <p class="text-[10px] tracking-widest uppercase font-medium" style="color:#C9AA71">
                                {{ $hab->tipo->nombre }}
                            </p>
                            <h3 class="font-serif text-xl font-light mt-0.5"
                                style="font-family:'Cormorant Garamond',Georgia,serif;color:#1A3A5C">
                                Habitación {{ $hab->numero }}
                            </h3>
                        </div>
                        <div class="text-right">
                            <div class="font-serif text-xl font-light" style="font-family:'Cormorant Garamond',Georgia,serif;color:#1A3A5C">
                                S/ {{ number_format($hab->tipo->precio_noche, 2) }}
                            </div>
                            <div class="text-[10px]" style="color:rgba(26,58,92,.4)">por noche</div>
                        </div>
                    </div>

                    <p class="text-sm leading-relaxed mb-4 line-clamp-2"
                       style="color:rgba(26,58,92,.6)">
                        {{ $hab->tipo->descripcion }}
                    </p>

                    <div class="flex items-center gap-4 mb-5 text-xs" style="color:rgba(26,58,92,.5)">
                        <span><i class="fas fa-users mr-1" style="color:#C9AA71"></i>{{ $hab->tipo->capacidad }} personas</span>
                        <span><i class="fas fa-wifi mr-1" style="color:#C9AA71"></i>WiFi</span>
                        <span><i class="fas fa-snowflake mr-1" style="color:#C9AA71"></i>AC</span>
                    </div>

                    <a href="{{ route('reservas.create', [
                            'habitacion_id'  => $hab->id,
                            'fecha_ingreso'  => request('fecha_ingreso'),
                            'fecha_salida'   => request('fecha_salida'),
                        ]) }}"
                       class="block text-center text-white text-xs tracking-widest uppercase font-semibold py-3 transition-all duration-200 hover:opacity-90"
                       style="background:#1A3A5C;text-decoration:none">
                        Reservar esta habitación
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif

    </div>
</section>
@endif

{{-- ══════════════════════════════════════════
     CTA BANNER (igual que welcome)
══════════════════════════════════════════ --}}
<section style="background:#C9AA71;padding:4rem 1.5rem">
    <div class="max-w-3xl mx-auto text-center reveal">
        <p class="text-[10px] tracking-widest uppercase mb-3 font-medium"
           style="color:rgba(13,33,55,.6)">Reserva Directa</p>
        <h2 class="font-serif text-3xl sm:text-4xl font-light mb-4"
            style="font-family:'Cormorant Garamond',Georgia,serif;color:#0D2137">
            Mejor precio garantizado<br>
            <em>al reservar directamente</em>
        </h2>
        <p class="text-sm mb-8 max-w-lg mx-auto" style="color:rgba(13,33,55,.65)">
            Sin intermediarios. Accede a beneficios exclusivos para huéspedes directos.
        </p>
        @guest('cliente')
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('registro') }}"
               class="text-white text-xs tracking-widest uppercase font-semibold px-10 py-4 transition-all duration-200 hover:shadow-xl w-full sm:w-auto text-center"
               style="background:#1A3A5C;text-decoration:none">
                Crear Cuenta
            </a>
            <a href="{{ route('login') }}"
               class="text-xs tracking-widest uppercase px-10 py-4 transition-all duration-200 w-full sm:w-auto text-center"
               style="border:2px solid #0D2137;color:#0D2137;text-decoration:none">
                Iniciar Sesión
            </a>
        </div>
        @endguest
    </div>
</section>

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
}, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
revealEls.forEach(el => obs.observe(el));
</script>

@endsection