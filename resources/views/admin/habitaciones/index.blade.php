@extends('layouts.app')
@section('title', 'Habitaciones — DoubleTree by Hilton Trujillo')

@section('content')

<style>
body { background: #F8F5EF; }

.hab-hero {
    background: #1A3A5C;
    position: relative;
    overflow: hidden;
    min-height: 380px;
    display: flex;
    align-items: center;
}
.hab-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: repeating-linear-gradient(45deg,rgba(201,170,113,.08) 0,rgba(201,170,113,.08) 1px,transparent 0,transparent 28px);
}

.hab-card {
    background: #fff;
    border: 1px solid rgba(201,170,113,.15);
    border-radius: 12px;
    overflow: hidden;
    transition: transform .25s, box-shadow .25s;
}
.hab-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(26,58,92,.12); }

.hab-card-img {
    height: 180px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.hab-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .5s;
}
.hab-card:hover .hab-card-img img { transform: scale(1.05); }

.badge-disponible {
    position: absolute;
    top: 10px; left: 10px;
    font-size: .6rem; font-weight: 600; letter-spacing: .08em;
    text-transform: uppercase;
    background: #22c55e; color: #fff;
    padding: .2rem .6rem; border-radius: 20px;
}
.badge-piso {
    position: absolute;
    top: 10px; right: 10px;
    font-size: .6rem; font-weight: 500;
    background: rgba(0,0,0,.45); color: #fff;
    padding: .2rem .6rem; border-radius: 20px;
    backdrop-filter: blur(4px);
}
.badge-tipo {
    position: absolute;
    bottom: 10px; left: 10px;
    font-size: .6rem; font-weight: 600; letter-spacing: .08em;
    text-transform: uppercase;
    background: rgba(201,170,113,.9); color: #0D2137;
    padding: .2rem .6rem; border-radius: 20px;
}

.avail-input {
    border: 1px solid #D9C08F;
    background: #FAFAF8;
    color: #1A3A5C;
    font-size: .875rem;
    padding: .65rem .875rem;
    outline: none;
    border-radius: 8px;
    transition: border-color .2s, box-shadow .2s;
    width: 100%;
    font-family: inherit;
}
.avail-input:focus {
    border-color: #1A3A5C;
    box-shadow: 0 0 0 3px rgba(26,58,92,.1);
}

.card-carrusel {
    min-width: 260px;
    flex-shrink: 0;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid rgba(201,170,113,.15);
    background: #fff;
    transition: transform .25s, box-shadow .25s;
}
.card-carrusel:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(26,58,92,.1); }

.section-tag {
    font-size: .6rem; font-weight: 500; letter-spacing: .15em;
    text-transform: uppercase; color: #C9AA71; margin-bottom: .375rem;
}
</style>

{{-- ══ HERO ══ --}}
<div class="hab-hero">
    <div style="position: relative; z-index: 1; max-width: 1100px; margin: 0 auto; padding: 3rem 1.5rem; width: 100%;">
        <div class="section-tag">Trujillo, Perú · 4 Estrellas</div>
        <h1 style="font-family:'Cormorant Garamond',Georgia,serif; font-size: clamp(2rem,5vw,3.5rem); font-weight: 300; color: #fff; line-height: 1.15; margin: 0 0 1rem;">
            Nuestras<br><em style="color:#C9AA71">Habitaciones</em>
        </h1>
        <p style="font-size: .9375rem; color: rgba(255,255,255,.6); max-width: 480px; line-height: 1.7; margin: 0 0 1.5rem;">
            147 habitaciones en 14 pisos diseñadas para ofrecerte descanso absoluto con los más altos estándares de confort.
        </p>
        <div style="display: flex; gap: 2rem;">
            @foreach([['147','Habitaciones'],['14','Pisos'],['3','Tipos']] as $s)
            <div>
                <div style="font-family:'Cormorant Garamond',Georgia,serif; font-size: 1.75rem; font-weight: 300; color: #C9AA71; line-height: 1;">{{ $s[0] }}</div>
                <div style="font-size: .6rem; letter-spacing: .12em; text-transform: uppercase; color: rgba(255,255,255,.45); margin-top: .2rem;">{{ $s[1] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ══ CARRUSEL DESTACADOS ══ --}}
<div style="background: #fff; padding: 3rem 0; border-bottom: 1px solid rgba(201,170,113,.15);">
    <div style="max-width: 1100px; margin: 0 auto; padding: 0 1.5rem;">
        <div style="display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 1.5rem;">
            <div>
                <div class="section-tag">Lo mejor del hotel</div>
                <h2 style="font-family:'Cormorant Garamond',Georgia,serif; font-size: 1.75rem; font-weight: 300; color: #1A3A5C; margin: 0;">
                    Habitaciones destacadas
                </h2>
            </div>
            <div style="display: flex; gap: .5rem;">
                <button onclick="scrollC(-1)" style="width:38px;height:38px;border-radius:50%;border:1px solid rgba(201,170,113,.4);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .2s;" onmouseover="this.style.background='#F8F5EF'" onmouseout="this.style.background='#fff'">
                    <i class="fa fa-chevron-left" style="font-size:12px;color:#1A3A5C;"></i>
                </button>
                <button onclick="scrollC(1)" style="width:38px;height:38px;border-radius:50%;border:1px solid rgba(201,170,113,.4);background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .2s;" onmouseover="this.style.background='#F8F5EF'" onmouseout="this.style.background='#fff'">
                    <i class="fa fa-chevron-right" style="font-size:12px;color:#1A3A5C;"></i>
                </button>
            </div>
        </div>

        <div id="carrusel" style="display:flex;gap:1rem;overflow-x:auto;scroll-behavior:smooth;scrollbar-width:none;padding-bottom:.5rem;">

            {{-- Matrimonial --}}
            <div class="card-carrusel">
                <div style="height:160px;overflow:hidden;position:relative;">
                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=600&q=80"
                         style="width:100%;height:100%;object-fit:cover;" alt="Matrimonial">
                    <span style="position:absolute;top:8px;right:8px;font-size:.6rem;font-weight:600;background:#C9AA71;color:#0D2137;padding:.2rem .6rem;border-radius:20px;text-transform:uppercase;letter-spacing:.06em;">Popular</span>
                </div>
                <div style="padding:1rem;">
                    <div class="section-tag">Habitación</div>
                    <h3 style="font-family:'Cormorant Garamond',Georgia,serif;font-size:1.25rem;font-weight:300;color:#1A3A5C;margin:0 0 .375rem;">Matrimonial</h3>
                    <p style="font-size:.75rem;color:rgba(26,58,92,.55);margin:0 0 .75rem;">King size · Vista ciudad · Pisos 1-10</p>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <div>
                            <span style="font-family:'Cormorant Garamond',Georgia,serif;font-size:1.375rem;font-weight:300;color:#1A3A5C;">S/ 150</span>
                            <span style="font-size:.7rem;color:rgba(26,58,92,.45);">/noche</span>
                        </div>
                        <a href="#buscador" style="font-size:.65rem;letter-spacing:.08em;text-transform:uppercase;font-weight:500;background:#1A3A5C;color:#fff;padding:.4rem .875rem;border-radius:6px;text-decoration:none;">Ver más</a>
                    </div>
                </div>
            </div>

            {{-- Doble --}}
            <div class="card-carrusel">
                <div style="height:160px;overflow:hidden;position:relative;">
                    <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=600&q=80"
                         style="width:100%;height:100%;object-fit:cover;" alt="Doble">
                    <span style="position:absolute;top:8px;right:8px;font-size:.6rem;font-weight:600;background:#0f6e56;color:#fff;padding:.2rem .6rem;border-radius:20px;text-transform:uppercase;letter-spacing:.06em;">Familias</span>
                </div>
                <div style="padding:1rem;">
                    <div class="section-tag">Habitación</div>
                    <h3 style="font-family:'Cormorant Garamond',Georgia,serif;font-size:1.25rem;font-weight:300;color:#1A3A5C;margin:0 0 .375rem;">Doble</h3>
                    <p style="font-size:.75rem;color:rgba(26,58,92,.55);margin:0 0 .75rem;">2 camas · Vista ciudad · Pisos 1-13</p>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <div>
                            <span style="font-family:'Cormorant Garamond',Georgia,serif;font-size:1.375rem;font-weight:300;color:#1A3A5C;">S/ 220</span>
                            <span style="font-size:.7rem;color:rgba(26,58,92,.45);">/noche</span>
                        </div>
                        <a href="#buscador" style="font-size:.65rem;letter-spacing:.08em;text-transform:uppercase;font-weight:500;background:#1A3A5C;color:#fff;padding:.4rem .875rem;border-radius:6px;text-decoration:none;">Ver más</a>
                    </div>
                </div>
            </div>

            {{-- Suite --}}
            <div class="card-carrusel">
                <div style="height:160px;overflow:hidden;position:relative;">
                    <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=600&q=80"
                         style="width:100%;height:100%;object-fit:cover;" alt="Suite">
                    <span style="position:absolute;top:8px;right:8px;font-size:.6rem;font-weight:600;background:#b8860b;color:#fff;padding:.2rem .6rem;border-radius:20px;text-transform:uppercase;letter-spacing:.06em;">Premium</span>
                </div>
                <div style="padding:1rem;">
                    <div class="section-tag">Suite de lujo</div>
                    <h3 style="font-family:'Cormorant Garamond',Georgia,serif;font-size:1.25rem;font-weight:300;color:#1A3A5C;margin:0 0 .375rem;">Suite</h3>
                    <p style="font-size:.75rem;color:rgba(26,58,92,.55);margin:0 0 .75rem;">Jacuzzi · Vista 360° · Piso 14</p>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <div>
                            <span style="font-family:'Cormorant Garamond',Georgia,serif;font-size:1.375rem;font-weight:300;color:#1A3A5C;">S/ 300</span>
                            <span style="font-size:.7rem;color:rgba(26,58,92,.45);">/noche</span>
                        </div>
                        <a href="#buscador" style="font-size:.65rem;letter-spacing:.08em;text-transform:uppercase;font-weight:500;background:#1A3A5C;color:#fff;padding:.4rem .875rem;border-radius:6px;text-decoration:none;">Ver más</a>
                    </div>
                </div>
            </div>

            {{-- Card beneficios --}}
            <div class="card-carrusel" style="background:#1A3A5C;border-color:#1A3A5C;">
                <div style="padding:1.25rem;height:100%;display:flex;flex-direction:column;justify-content:space-between;min-height:280px;">
                    <div>
                        <div style="font-size:.6rem;letter-spacing:.15em;text-transform:uppercase;color:#C9AA71;margin-bottom:1rem;">¿Por qué elegirnos?</div>
                        <ul style="list-style:none;padding:0;margin:0;space-y:.75rem;">
                            @foreach(['147 habitaciones disponibles','14 pisos con vista panorámica','11 km del aeropuerto','Valoración 9.1/10','Pago seguro MercadoPago'] as $b)
                            <li style="display:flex;align-items:center;gap:.625rem;font-size:.8125rem;color:rgba(255,255,255,.65);margin-bottom:.625rem;">
                                <i class="fa fa-check" style="color:#C9AA71;font-size:10px;flex-shrink:0;"></i>
                                {{ $b }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <a href="#buscador" style="display:block;text-align:center;font-size:.65rem;letter-spacing:.1em;text-transform:uppercase;font-weight:500;background:#C9AA71;color:#0D2137;padding:.625rem;border-radius:6px;text-decoration:none;margin-top:1rem;">
                        Reservar ahora
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ══ BUSCADOR ══ --}}
<div id="buscador" style="background:#F8F5EF;padding:3rem 0;">
    <div style="max-width:1100px;margin:0 auto;padding:0 1.5rem;">

        <div style="text-align:center;margin-bottom:2rem;">
            <div class="section-tag">Disponibilidad en tiempo real</div>
            <h2 style="font-family:'Cormorant Garamond',Georgia,serif;font-size:1.75rem;font-weight:300;color:#1A3A5C;margin:0;">
                Busca tu habitación ideal
            </h2>
        </div>

        {{-- Formulario --}}
        <div style="background:#fff;border:1px solid rgba(201,170,113,.2);border-radius:12px;padding:1.5rem;margin-bottom:2rem;">
            <form method="GET" action="{{ route('habitaciones.index') }}"
                  style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr auto;gap:1rem;align-items:end;">

                <div>
                    <label style="display:block;font-size:.6rem;font-weight:500;letter-spacing:.1em;text-transform:uppercase;color:rgba(26,58,92,.55);margin-bottom:.5rem;">
                        Tipo de habitación
                    </label>
                    <select name="tipo_id" class="avail-input">
                        <option value="">Todos los tipos</option>
                        @foreach($tipos as $tipo)
                            <option value="{{ $tipo->id }}" {{ request('tipo_id') == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nombre }} — S/ {{ number_format($tipo->precio_noche,2) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display:block;font-size:.6rem;font-weight:500;letter-spacing:.1em;text-transform:uppercase;color:rgba(26,58,92,.55);margin-bottom:.5rem;">
                        Check-in
                    </label>
                    <input type="datetime-local" name="fecha_ingreso"
                           value="{{ request('fecha_ingreso') }}" class="avail-input">
                </div>

                <div>
                    <label style="display:block;font-size:.6rem;font-weight:500;letter-spacing:.1em;text-transform:uppercase;color:rgba(26,58,92,.55);margin-bottom:.5rem;">
                        Check-out
                    </label>
                    <input type="datetime-local" name="fecha_salida"
                           value="{{ request('fecha_salida') }}" class="avail-input">
                </div>

                <div>
                    <label style="display:block;font-size:.6rem;font-weight:500;letter-spacing:.1em;text-transform:uppercase;color:rgba(26,58,92,.55);margin-bottom:.5rem;">
                        Huéspedes
                    </label>
                    <select name="huespedes" class="avail-input">
                        @foreach([1,2,3,4] as $n)
                        <option value="{{ $n }}" {{ request('huespedes',2)==$n?'selected':'' }}>
                            {{ $n }} {{ $n==1?'persona':'personas' }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div style="display:flex;gap:.5rem;">
                    <button type="submit"
                            style="font-size:.65rem;letter-spacing:.1em;text-transform:uppercase;font-weight:500;background:#1A3A5C;color:#fff;padding:.65rem 1.25rem;border:none;border-radius:8px;cursor:pointer;white-space:nowrap;transition:opacity .2s;"
                            onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                        <i class="fa fa-search" style="margin-right:.4rem;color:rgba(201,170,113,.8);"></i>Buscar
                    </button>
                    @if(request()->hasAny(['tipo_id','fecha_ingreso','fecha_salida','huespedes']))
                    <a href="{{ route('habitaciones.index') }}"
                       style="font-size:.65rem;background:#F8F5EF;color:rgba(26,58,92,.6);border:1px solid rgba(201,170,113,.3);padding:.65rem .875rem;border-radius:8px;text-decoration:none;display:flex;align-items:center;">
                        <i class="fa fa-xmark"></i>
                    </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Resultados --}}
        @if(request()->hasAny(['tipo_id','fecha_ingreso','fecha_salida','huespedes']))

            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;">
                <div>
                    <span style="font-family:'Cormorant Garamond',Georgia,serif;font-size:2rem;font-weight:300;color:#1A3A5C;">{{ $habitaciones->count() }}</span>
                    <span style="font-size:.875rem;color:rgba(26,58,92,.6);margin-left:.375rem;">habitación(es) disponible(s)</span>
                </div>
            </div>

            @if($habitaciones->isEmpty())
            <div style="background:#fff;border:1px dashed rgba(201,170,113,.4);border-radius:12px;padding:3.5rem;text-align:center;">
                <i class="fa fa-bed" style="font-size:2.5rem;color:rgba(201,170,113,.35);display:block;margin-bottom:1rem;"></i>
                <p style="font-family:'Cormorant Garamond',Georgia,serif;font-size:1.375rem;font-weight:300;color:#1A3A5C;margin:0 0 .5rem;">Sin disponibilidad para esas fechas</p>
                <p style="font-size:.8125rem;color:rgba(26,58,92,.55);margin:0 0 1.25rem;">Prueba con otras fechas o un tipo diferente.</p>
                <a href="{{ route('habitaciones.index') }}"
                   style="font-size:.65rem;letter-spacing:.1em;text-transform:uppercase;font-weight:500;background:#1A3A5C;color:#fff;padding:.625rem 1.5rem;border-radius:8px;text-decoration:none;">
                    Limpiar filtros
                </a>
            </div>

            @else
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.25rem;">
                @foreach($habitaciones as $hab)
                @php
                    $imgs = [
                        'Matrimonial' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=600&q=80',
                        'Doble'       => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=600&q=80',
                        'Suite'       => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=600&q=80',
                    ];
                    $img = $imgs[$hab->tipo->nombre] ?? $imgs['Matrimonial'];
                @endphp
                <div class="hab-card">
                    <div class="hab-card-img">
                        <img src="{{ $img }}" alt="{{ $hab->tipo->nombre }}">
                        <span class="badge-disponible">Disponible</span>
                        <span class="badge-piso">Piso {{ $hab->piso }}</span>
                        <span class="badge-tipo">{{ $hab->tipo->nombre }}</span>
                    </div>
                    <div style="padding:1.125rem;">
                        <div style="display:flex;align-items:start;justify-content:space-between;margin-bottom:.625rem;">
                            <div>
                                <h3 style="font-family:'Cormorant Garamond',Georgia,serif;font-size:1.25rem;font-weight:300;color:#1A3A5C;margin:0 0 .2rem;">
                                    Habitación {{ $hab->numero }}
                                </h3>
                                <p style="font-size:.75rem;color:rgba(26,58,92,.5);margin:0;">
                                    {{ $hab->tipo->descripcion }}
                                </p>
                            </div>
                        </div>
                        <div style="display:flex;gap:1rem;margin-bottom:.875rem;">
                            <span style="font-size:.7rem;color:rgba(26,58,92,.55);display:flex;align-items:center;gap:.3rem;">
                                <i class="fa fa-users" style="color:#C9AA71;font-size:10px;"></i>
                                Hasta {{ $hab->tipo->capacidad }} pers.
                            </span>
                            <span style="font-size:.7rem;color:rgba(26,58,92,.55);display:flex;align-items:center;gap:.3rem;">
                                <i class="fa fa-wifi" style="color:#C9AA71;font-size:10px;"></i>WiFi
                            </span>
                            <span style="font-size:.7rem;color:rgba(26,58,92,.55);display:flex;align-items:center;gap:.3rem;">
                                <i class="fa fa-snowflake" style="color:#C9AA71;font-size:10px;"></i>A/C
                            </span>
                        </div>
                        <div style="display:flex;align-items:center;justify-content:space-between;border-top:1px solid rgba(201,170,113,.15);padding-top:.875rem;">
                            <div>
                                <span style="font-family:'Cormorant Garamond',Georgia,serif;font-size:1.375rem;font-weight:300;color:#1A3A5C;">
                                    S/ {{ number_format($hab->tipo->precio_noche,2) }}
                                </span>
                                <span style="font-size:.7rem;color:rgba(26,58,92,.45);">/noche</span>
                            </div>
                            <a href="{{ route('reservas.create', ['habitacion_id'=>$hab->id,'fecha_ingreso'=>request('fecha_ingreso'),'fecha_salida'=>request('fecha_salida')]) }}"
                               style="font-size:.65rem;letter-spacing:.08em;text-transform:uppercase;font-weight:500;background:#C9AA71;color:#0D2137;padding:.5rem 1rem;border-radius:6px;text-decoration:none;transition:opacity .2s;"
                               onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                                Reservar
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

        @else
        {{-- Sin búsqueda --}}
        <div style="background:#fff;border:1px dashed rgba(201,170,113,.3);border-radius:12px;padding:3.5rem;text-align:center;">
            <i class="fa fa-magnifying-glass" style="font-size:2.5rem;color:rgba(201,170,113,.35);display:block;margin-bottom:1rem;"></i>
            <p style="font-family:'Cormorant Garamond',Georgia,serif;font-size:1.375rem;font-weight:300;color:#1A3A5C;margin:0 0 .375rem;">
                Elige tus fechas para ver disponibilidad
            </p>
            <p style="font-size:.8125rem;color:rgba(26,58,92,.55);margin:0;">
                Selecciona tipo, fechas y número de huéspedes
            </p>
        </div>
        @endif

    </div>
</div>

<script>
function scrollC(dir) {
    document.getElementById('carrusel').scrollBy({ left: dir * 280, behavior: 'smooth' });
}
</script>

@endsection