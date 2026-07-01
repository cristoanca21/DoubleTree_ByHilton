@extends('layouts.app')
@section('title', 'Habitaciones — DoubleTree by Hilton Trujillo')

@section('content')

{{-- ══ HERO BANNER ══ --}}
<div class="relative bg-doubletree-navy overflow-hidden" style="height: 420px;">
    <div class="absolute inset-0 bg-gradient-to-r from-doubletree-navy via-doubletree-navy/80 to-transparent z-10"></div>
    {{-- Fondo decorativo --}}
    <div class="absolute inset-0 opacity-20"
         style="background: repeating-linear-gradient(45deg,#C9AA71 0,#C9AA71 1px,transparent 0,transparent 50%) 0/20px 20px;">
    </div>
    <div class="relative z-20 max-w-7xl mx-auto px-6 h-full flex flex-col justify-center">
        <p class="text-doubletree-gold text-sm font-medium tracking-widest uppercase mb-2">
            4 Estrellas · Trujillo, Perú
        </p>
        <h1 class="text-white text-4xl md:text-5xl font-bold leading-tight mb-4">
            Descubre el confort<br>que mereces
        </h1>
        <p class="text-gray-300 text-lg mb-6 max-w-xl">
            Descubra la calidez de nuestra hospitalidad en la Ciudad de la Eterna Primavera.
        </p>
        <a href="#buscador"
           class="inline-flex items-center gap-2 bg-doubletree-gold text-white px-6 py-3 rounded-xl font-medium hover:bg-yellow-600 transition w-fit">
            <i class="fa fa-search"></i> Buscar habitación
        </a>
    </div>
</div>

{{-- ══ DESTACADOS (carrusel) ══ --}}
<div class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-doubletree-gold text-xs font-semibold tracking-widest uppercase">Lo mejor del hotel</p>
                <h2 class="text-2xl font-bold text-doubletree-navy">Habitaciones destacadas</h2>
            </div>
            <div class="flex gap-2">
                <button onclick="scrollCarrusel(-1)"
                        class="w-10 h-10 rounded-full border border-gray-200 hover:bg-gray-50 transition flex items-center justify-center">
                    <i class="fa fa-chevron-left text-doubletree-navy text-sm"></i>
                </button>
                <button onclick="scrollCarrusel(1)"
                        class="w-10 h-10 rounded-full border border-gray-200 hover:bg-gray-50 transition flex items-center justify-center">
                    <i class="fa fa-chevron-right text-doubletree-navy text-sm"></i>
                </button>
            </div>
        </div>

        <div id="carrusel" class="flex gap-5 overflow-x-auto scroll-smooth pb-2"
             style="scrollbar-width:none;">
            {{-- Matrimonial --}}
            <div class="min-w-[280px] bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 flex-shrink-0">
                <div class="bg-doubletree-navy h-44 flex items-center justify-center relative">
                    <i class="fa fa-bed text-6xl doubletree-gold opacity-80"></i>
                    <span class="absolute top-3 right-3 bg-doubletree-gold text-white text-xs font-bold px-2 py-1 rounded-full">
                        Más popular
                    </span>
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-doubletree-navy text-lg">Matrimonial</h3>
                    <p class="text-gray-500 text-sm mb-3">Cama King · Vista ciudad o mar · Pisos 1-10</p>
                    <div class="flex items-center gap-3 mb-4 text-xs text-gray-500">
                        <span><i class="fa fa-users mr-1"></i>Hasta 2 personas</span>
                        <span><i class="fa fa-wifi mr-1"></i>WiFi</span>
                        <span><i class="fa fa-tv mr-1"></i>TV 55"</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-2xl font-bold text-doubletree-navy">S/ 280</span>
                            <span class="text-gray-400 text-xs">/noche</span>
                        </div>
                        <a href="#buscador"
                           class="bg-doubletree-navy text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-900 transition">
                            Ver más
                        </a>
                    </div>
                </div>
            </div>

            {{-- Doble --}}
            <div class="min-w-[280px] bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 flex-shrink-0">
                <div class="bg-teal-700 h-44 flex items-center justify-center relative">
                    <i class="fa fa-bed text-6xl text-white opacity-80"></i>
                    <span class="absolute top-3 right-3 bg-teal-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                        Familias
                    </span>
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-doubletree-navy text-lg">Doble</h3>
                    <p class="text-gray-500 text-sm mb-3">2 camas dobles · Vista ciudad · Pisos 1-13</p>
                    <div class="flex items-center gap-3 mb-4 text-xs text-gray-500">
                        <span><i class="fa fa-users mr-1"></i>Hasta 3 personas</span>
                        <span><i class="fa fa-wifi mr-1"></i>WiFi</span>
                        <span><i class="fa fa-snowflake mr-1"></i>A/C</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-2xl font-bold text-doubletree-navy">S/ 320</span>
                            <span class="text-gray-400 text-xs">/noche</span>
                        </div>
                        <a href="#buscador"
                           class="bg-doubletree-navy text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-900 transition">
                            Ver más
                        </a>
                    </div>
                </div>
            </div>

            {{-- Suite --}}
            <div class="min-w-[280px] bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 flex-shrink-0">
                <div class="bg-yellow-700 h-44 flex items-center justify-center relative">
                    <i class="fa fa-star text-6xl text-white opacity-80"></i>
                    <span class="absolute top-3 right-3 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                        Premium
                    </span>
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-doubletree-navy text-lg">Suite</h3>
                    <p class="text-gray-500 text-sm mb-3">Jacuzzi · Vista 360° · Piso 14 exclusivo</p>
                    <div class="flex items-center gap-3 mb-4 text-xs text-gray-500">
                        <span><i class="fa fa-users mr-1"></i>Hasta 4 personas</span>
                        <span><i class="fa fa-bath mr-1"></i>Jacuzzi</span>
                        <span><i class="fa fa-martini-glass mr-1"></i>Minibar</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-2xl font-bold text-doubletree-navy">S/ 680</span>
                            <span class="text-gray-400 text-xs">/noche</span>
                        </div>
                        <a href="#buscador"
                           class="bg-doubletree-navy text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-900 transition">
                            Ver más
                        </a>
                    </div>
                </div>
            </div>

            {{-- Info card --}}
            <div class="min-w-[280px] bg-doubletree-navy rounded-2xl p-6 flex-shrink-0 flex flex-col justify-between">
                <div>
                    <p class="doubletree-gold text-xs font-semibold tracking-widest uppercase mb-3">¿Por qué elegirnos?</p>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li class="flex items-center gap-2"><i class="fa fa-check doubletree-gold"></i>147 habitaciones disponibles</li>
                        <li class="flex items-center gap-2"><i class="fa fa-check doubletree-gold"></i>14 pisos con vista panorámica</li>
                        <li class="flex items-center gap-2"><i class="fa fa-check doubletree-gold"></i>11 km del aeropuerto</li>
                        <li class="flex items-center gap-2"><i class="fa fa-check doubletree-gold"></i>Valoración 9.1/10</li>
                        <li class="flex items-center gap-2"><i class="fa fa-check doubletree-gold"></i>Pago seguro MercadoPago</li>
                    </ul>
                </div>
                <a href="#buscador"
                   class="mt-6 bg-doubletree-gold text-white py-2.5 rounded-lg text-sm font-medium text-center hover:bg-yellow-600 transition block">
                    Reservar ahora
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ══ BUSCADOR ══ --}}
<div id="buscador" class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-8">
            <p class="text-doubletree-gold text-xs font-semibold tracking-widest uppercase mb-2">Disponibilidad</p>
            <h2 class="text-2xl font-bold text-doubletree-navy">Busca tu habitación ideal</h2>
        </div>

        {{-- Filtros --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-8">
            <form method="GET" action="{{ route('habitaciones.index') }}"
                  class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                        Tipo de habitación
                    </label>
                    <select name="tipo_id"
                            class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-white">
                        <option value="">Todos los tipos</option>
                        @foreach($tipos as $tipo)
                            <option value="{{ $tipo->id }}"
                                {{ request('tipo_id') == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nombre }} — S/ {{ number_format($tipo->precio_noche, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                        Fecha ingreso
                    </label>
                    <input type="datetime-local" name="fecha_ingreso"
                           value="{{ request('fecha_ingreso') }}"
                           class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                        Fecha salida
                    </label>
                    <input type="datetime-local" name="fecha_salida"
                           value="{{ request('fecha_salida') }}"
                           class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                        Huéspedes
                    </label>
                    <select name="huespedes"
                            class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 bg-white">
                        <option value="1" {{ request('huespedes',1)==1?'selected':'' }}>1 persona</option>
                        <option value="2" {{ request('huespedes',1)==2?'selected':'' }}>2 personas</option>
                        <option value="3" {{ request('huespedes',1)==3?'selected':'' }}>3 personas</option>
                        <option value="4" {{ request('huespedes',1)==4?'selected':'' }}>4 personas</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                            class="flex-1 bg-doubletree-navy text-white py-2.5 rounded-xl text-sm font-medium hover:bg-blue-900 transition">
                        <i class="fa fa-search mr-1"></i>Buscar
                    </button>
                    @if(request()->hasAny(['tipo_id','fecha_ingreso','fecha_salida','huespedes']))
                        <a href="{{ route('habitaciones.index') }}"
                           class="bg-gray-100 text-gray-500 px-4 py-2.5 rounded-xl text-sm hover:bg-gray-200 transition">
                            <i class="fa fa-xmark"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Resultados --}}
        @if(request()->hasAny(['tipo_id','fecha_ingreso','fecha_salida','huespedes']))
            <div class="mb-4 flex items-center justify-between">
                <p class="text-doubletree-navy font-medium">
                    <span class="text-2xl font-bold">{{ $habitaciones->count() }}</span>
                    habitación(es) encontrada(s)
                </p>
            </div>

            @if($habitaciones->isEmpty())
                <div class="bg-white rounded-2xl p-10 text-center shadow-sm">
                    <i class="fa fa-bed text-5xl text-gray-200 mb-4"></i>
                    <p class="text-gray-500 font-medium">No hay habitaciones disponibles con esos filtros.</p>
                    <a href="{{ route('habitaciones.index') }}"
                       class="text-doubletree-gold text-sm underline mt-2 inline-block">
                        Limpiar filtros
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($habitaciones as $hab)
                        @php
                            $colores = ['Matrimonial'=>'bg-doubletree-navy','Doble'=>'bg-teal-700','Suite'=>'bg-yellow-700'];
                            $color   = $colores[$hab->tipo->nombre] ?? 'bg-gray-600';
                        @endphp
                        <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden border border-gray-100">
                            <div class="{{ $color }} h-36 flex items-center justify-center relative">
                                <i class="fa fa-bed text-5xl text-white opacity-70"></i>
                                <span class="absolute top-3 left-3 bg-green-400 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    Disponible
                                </span>
                                <span class="absolute top-3 right-3 bg-black/30 text-white text-xs px-2 py-1 rounded-full">
                                    Piso {{ $hab->piso }}
                                </span>
                            </div>
                            <div class="p-5">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="font-bold text-doubletree-navy text-lg">
                                            Hab. {{ $hab->numero }}
                                        </h3>
                                        <p class="text-gray-400 text-sm">{{ $hab->tipo->nombre }}</p>
                                    </div>
                                </div>
                                <p class="text-gray-500 text-sm mb-3 line-clamp-2">
                                    {{ $hab->tipo->descripcion }}
                                </p>
                                <div class="flex items-center gap-3 text-xs text-gray-400 mb-4">
                                    <span><i class="fa fa-users mr-1"></i>Hasta {{ $hab->tipo->capacidad }} personas</span>
                                    <span><i class="fa fa-wifi mr-1"></i>WiFi</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="text-xl font-bold text-doubletree-navy">
                                            S/ {{ number_format($hab->tipo->precio_noche, 2) }}
                                        </span>
                                        <span class="text-gray-400 text-xs">/noche</span>
                                    </div>
                                    <a href="{{ route('reservas.create', ['habitacion_id' => $hab->id, 'fecha_ingreso' => request('fecha_ingreso'), 'fecha_salida' => request('fecha_salida')]) }}"
                                       class="bg-doubletree-gold text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-yellow-600 transition">
                                        Reservar
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @else
            {{-- Sin búsqueda activa --}}
            <div class="bg-white rounded-2xl p-10 text-center shadow-sm border border-dashed border-gray-200">
                <i class="fa fa-magnifying-glass text-4xl text-gray-200 mb-4"></i>
                <p class="text-gray-500 font-medium">Usa los filtros para buscar habitaciones disponibles</p>
                <p class="text-gray-400 text-sm mt-1">Selecciona tipo, fechas y número de huéspedes</p>
            </div>
        @endif
    </div>
</div>

<script>
function scrollCarrusel(dir) {
    const c = document.getElementById('carrusel');
    c.scrollBy({ left: dir * 300, behavior: 'smooth' });
}
</script>

@endsection