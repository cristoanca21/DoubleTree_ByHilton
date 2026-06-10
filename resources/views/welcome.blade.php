<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DoubleTree by Hilton Trujillo — Hotel de Lujo en el Norte del Perú</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Google Fonts: Cormorant Garamond + Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy:   { DEFAULT: '#1A3A5C', deep: '#0D2137', light: '#2A5080', muted: '#1A3A5C' },
                        gold:   { DEFAULT: '#C9AA71', light: '#D9C08F', dark: '#A8864A', pale: '#F2E8D0' },
                        ivory:  { DEFAULT: '#F8F5EF', warm: '#F0EBE0' },
                    },
                    fontFamily: {
                        serif:  ['Cormorant Garamond', 'Georgia', 'serif'],
                        sans:   ['Inter', 'system-ui', 'sans-serif'],
                    },
                    letterSpacing: {
                        widest2: '0.25em',
                        widest3: '0.35em',
                    },
                }
            }
        }
    </script>

    <style>
        /* ── Global ── */
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; background: #F8F5EF; color: #1A3A5C; }

        /* ── Hero ── */
        .hero-bg {
            background-image:
                linear-gradient(to bottom, rgba(13,33,55,0.55) 0%, rgba(13,33,55,0.35) 50%, rgba(13,33,55,0.72) 100%),
                url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1800&q=85');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        /* ── Gold ornamental divider ── */
        .divider-gold {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .divider-gold::before,
        .divider-gold::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #C9AA71;
            opacity: 0.45;
        }

        /* ── Availability bar ── */
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

        /* ── Room cards ── */
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

        /* ── Nav ── */
        .nav-transparent { background: transparent; }
        .nav-solid {
            background: rgba(13,33,55,0.97);
            backdrop-filter: blur(12px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.25);
        }

        /* ── Testimonial ── */
        .testimonial-card {
            border-left: 3px solid #C9AA71;
        }

        /* ── Animations ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.9s ease forwards; }
        .delay-1 { animation-delay: 0.15s; opacity: 0; }
        .delay-2 { animation-delay: 0.30s; opacity: 0; }
        .delay-3 { animation-delay: 0.45s; opacity: 0; }
        .delay-4 { animation-delay: 0.60s; opacity: 0; }

        /* ── Scroll-reveal utility ── */
        .reveal { opacity: 0; transform: translateY(24px); transition: opacity 0.7s ease, transform 0.7s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* ── Footer ── */
        footer a:hover { color: #C9AA71; }
    </style>
</head>
<body class="antialiased">

{{-- ═══════════════════════════════════════════
     NAVIGATION
═══════════════════════════════════════════ --}}
<nav id="navbar" class="nav-transparent fixed top-0 left-0 right-0 z-50 transition-all duration-500">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">

            {{-- Logo --}}
            <a href="{{ route('welcome') }}" class="flex flex-col leading-none">
                <span class="font-serif text-white text-xs tracking-widest2 uppercase opacity-80">DoubleTree by</span>
                <span class="font-serif text-white text-xl font-light tracking-wide">Hilton Trujillo</span>
                <span class="text-gold text-[10px] tracking-widest3 uppercase mt-0.5">Hotel & Suites</span>
            </a>

            {{-- Links (desktop) --}}
            <div class="hidden lg:flex items-center gap-8">
                <a href="#habitaciones" class="text-white/80 hover:text-gold text-xs tracking-widest uppercase transition-colors duration-200">Habitaciones</a>
                <a href="#experiencias" class="text-white/80 hover:text-gold text-xs tracking-widest uppercase transition-colors duration-200">Experiencias</a>
                <a href="#nosotros" class="text-white/80 hover:text-gold text-xs tracking-widest uppercase transition-colors duration-200">El Hotel</a>
                <a href="#contacto" class="text-white/80 hover:text-gold text-xs tracking-widest uppercase transition-colors duration-200">Contacto</a>
            </div>

            {{-- Auth actions --}}
            <div class="flex items-center gap-3">
                @guest('cliente')
                    <a href="{{ route('cliente.login') }}"
                       class="text-white/85 hover:text-gold text-xs tracking-widest uppercase transition-colors duration-200 hidden sm:block">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('cliente.registro') }}"
                       class="bg-gold hover:bg-gold-dark text-navy-deep text-xs tracking-widest uppercase font-semibold px-5 py-2.5 transition-all duration-200 hover:shadow-lg">
                        Reservar
                    </a>
                @else
                    <div class="flex items-center gap-3">
                        @if(auth('cliente')->user()->rol === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                               class="text-white/80 hover:text-gold text-xs tracking-widest uppercase transition-colors duration-200">
                                <i class="fas fa-cog mr-1.5 text-gold/70"></i>Admin
                            </a>
                        @endif
                        <a href="{{ route('cliente.dashboard') }}"
                           class="text-white/85 hover:text-gold text-xs tracking-widest uppercase transition-colors duration-200 hidden sm:block">
                            <i class="fas fa-user-circle mr-1.5"></i>{{ auth('cliente')->user()->nombre }}
                        </a>
                        <form method="POST" action="{{ route('cliente.logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                    class="bg-gold hover:bg-gold-dark text-navy-deep text-xs tracking-widest uppercase font-semibold px-5 py-2.5 transition-all duration-200">
                                Salir
                            </button>
                        </form>
                    </div>
                @endguest

                {{-- Mobile menu toggle --}}
                <button id="mobileMenuBtn" class="lg:hidden text-white/80 hover:text-gold ml-2 transition-colors">
                    <i class="fas fa-bars text-lg"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div id="mobileMenu" class="hidden lg:hidden bg-navy-deep/98 border-t border-gold/20">
        <div class="px-6 py-4 flex flex-col gap-4">
            <a href="#habitaciones" class="text-white/80 hover:text-gold text-xs tracking-widest uppercase">Habitaciones</a>
            <a href="#experiencias" class="text-white/80 hover:text-gold text-xs tracking-widest uppercase">Experiencias</a>
            <a href="#nosotros" class="text-white/80 hover:text-gold text-xs tracking-widest uppercase">El Hotel</a>
            <a href="#contacto" class="text-white/80 hover:text-gold text-xs tracking-widest uppercase">Contacto</a>
            @guest('cliente')
                <a href="{{ route('cliente.login') }}" class="text-white/80 hover:text-gold text-xs tracking-widest uppercase">Iniciar Sesión</a>
            @endguest
        </div>
    </div>
</nav>


{{-- ═══════════════════════════════════════════
     HERO SECTION
═══════════════════════════════════════════ --}}
<section class="hero-bg relative min-h-screen flex flex-col">

    {{-- Hero copy --}}
    <div class="flex-1 flex items-center justify-center text-center px-6 pt-32 pb-56">
        <div class="max-w-3xl">
            <p class="fade-up text-gold text-xs tracking-widest3 uppercase mb-4 font-medium">
                Trujillo · La Ciudad de la Eterna Primavera
            </p>
            <h1 class="fade-up delay-1 font-serif text-white font-light leading-none">
                <span class="block text-5xl sm:text-7xl lg:text-8xl">Una Estancia</span>
                <span class="block text-5xl sm:text-7xl lg:text-8xl italic text-gold">Extraordinaria</span>
            </h1>
            <p class="fade-up delay-2 text-white/70 text-base sm:text-lg font-light mt-7 leading-relaxed max-w-xl mx-auto">
                Descubra el arte de la hospitalidad en el corazón del norte peruano. 147 habitaciones
                diseñadas para quienes exigen lo mejor.
            </p>
            <div class="fade-up delay-3 flex flex-col sm:flex-row items-center justify-center gap-4 mt-10">
                <a href="#disponibilidad"
                   class="bg-gold hover:bg-gold-dark text-navy-deep text-xs tracking-widest uppercase font-semibold px-8 py-4 transition-all duration-200 hover:shadow-xl w-full sm:w-auto text-center">
                    Verificar Disponibilidad
                </a>
                <a href="#habitaciones"
                   class="border border-white/50 hover:border-gold text-white hover:text-gold text-xs tracking-widest uppercase px-8 py-4 transition-all duration-200 w-full sm:w-auto text-center">
                    Ver Habitaciones
                </a>
            </div>
        </div>
    </div>

    {{-- Stats bar --}}
    <div class="fade-up delay-4 absolute bottom-36 left-0 right-0 hidden lg:block">
        <div class="max-w-4xl mx-auto px-6">
            <div class="grid grid-cols-4 divide-x divide-white/20">
                @foreach([
                    ['147', 'Habitaciones'],
                    ['14',  'Pisos'],
                    ['24/7','Servicio'],
                    ['★ 5', 'Estrellas']
                ] as $stat)
                <div class="text-center px-6 py-3">
                    <div class="font-serif text-gold text-2xl font-light">{{ $stat[0] }}</div>
                    <div class="text-white/60 text-[10px] tracking-widest uppercase mt-0.5">{{ $stat[1] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Scroll cue --}}
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 opacity-60">
        <span class="text-white text-[10px] tracking-widest uppercase">Deslizar</span>
        <div class="w-px h-8 bg-gold/60 animate-bounce"></div>
    </div>
</section>


{{-- ═══════════════════════════════════════════
     AVAILABILITY SEARCH BAR
═══════════════════════════════════════════ --}}
<div id="disponibilidad" class="avail-bar sticky top-0 z-40 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <form action="{{ route('habitaciones.index') }}" method="GET"
              class="flex flex-col lg:flex-row items-center gap-3 lg:gap-4">

            <div class="w-full lg:flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

                {{-- Check-in --}}
                <div class="flex flex-col">
                    <label class="text-[10px] tracking-widest uppercase text-navy/60 font-medium mb-1 ml-1">Check-in</label>
                    <input type="date" name="checkin"
                           value="{{ request('checkin', date('Y-m-d')) }}"
                           min="{{ date('Y-m-d') }}"
                           class="avail-input rounded px-3 py-2.5">
                </div>

                {{-- Check-out --}}
                <div class="flex flex-col">
                    <label class="text-[10px] tracking-widest uppercase text-navy/60 font-medium mb-1 ml-1">Check-out</label>
                    <input type="date" name="checkout"
                           value="{{ request('checkout', date('Y-m-d', strtotime('+1 day'))) }}"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           class="avail-input rounded px-3 py-2.5">
                </div>

                {{-- Tipo habitación --}}
                <div class="flex flex-col">
                    <label class="text-[10px] tracking-widest uppercase text-navy/60 font-medium mb-1 ml-1">Tipo de Habitación</label>
                    <select name="tipo_habitacion" class="avail-input rounded px-3 py-2.5">
                        <option value="">Cualquier tipo</option>
                        <option value="Matrimonial" {{ request('tipo_habitacion') == 'Matrimonial' ? 'selected' : '' }}>Matrimonial · S/ 150</option>
                        <option value="Doble"       {{ request('tipo_habitacion') == 'Doble'       ? 'selected' : '' }}>Doble · S/ 220</option>
                        <option value="Suite"       {{ request('tipo_habitacion') == 'Suite'       ? 'selected' : '' }}>Suite · S/ 300</option>
                    </select>
                </div>

                {{-- Huéspedes --}}
                <div class="flex flex-col">
                    <label class="text-[10px] tracking-widest uppercase text-navy/60 font-medium mb-1 ml-1">Huéspedes</label>
                    <select name="huespedes" class="avail-input rounded px-3 py-2.5">
                        <option value="1">1 Huésped</option>
                        <option value="2" selected>2 Huéspedes</option>
                        <option value="3">3 Huéspedes</option>
                        <option value="4">4 Huéspedes</option>
                    </select>
                </div>
            </div>

            <button type="submit"
                    class="w-full lg:w-auto bg-navy hover:bg-navy-deep text-white text-xs tracking-widest uppercase font-semibold px-8 py-3 transition-all duration-200 hover:shadow-lg whitespace-nowrap mt-1 lg:mt-4">
                <i class="fas fa-search mr-2 text-gold/80"></i>Verificar Disponibilidad
            </button>
        </form>
    </div>
</div>


{{-- ═══════════════════════════════════════════
     ROOMS SECTION
═══════════════════════════════════════════ --}}
<section id="habitaciones" class="bg-ivory py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        {{-- Section header --}}
        <div class="text-center mb-16 reveal">
            <p class="text-gold text-[10px] tracking-widest3 uppercase font-medium mb-3">Acomodaciones</p>
            <h2 class="font-serif text-navy text-4xl sm:text-5xl font-light">Nuestras Habitaciones</h2>
            <div class="divider-gold max-w-xs mx-auto mt-5">
                <i class="fas fa-star text-gold text-[10px]"></i>
            </div>
            <p class="text-navy/60 text-sm font-light mt-5 max-w-xl mx-auto leading-relaxed">
                Cada espacio ha sido concebido para brindar descanso absoluto, con vistas al norte del Perú
                y los más altos estándares de confort.
            </p>
        </div>

        {{-- Room cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Matrimonial --}}
            <div class="room-card bg-white reveal">
                <div class="overflow-hidden h-64">
                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=800&q=80"
                         alt="Habitación Matrimonial"
                         class="w-full h-full object-cover">
                </div>
                <div class="p-7">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <p class="text-[10px] tracking-widest uppercase text-gold font-medium mb-1">Habitación</p>
                            <h3 class="font-serif text-navy text-2xl font-light">Matrimonial</h3>
                        </div>
                        <div class="text-right">
                            <span class="text-navy/40 text-xs">Desde</span>
                            <div class="font-serif text-navy text-2xl font-light">S/ 150</div>
                            <span class="text-navy/40 text-[10px]">por noche</span>
                        </div>
                    </div>
                    <p class="text-navy/60 text-sm leading-relaxed mb-5">
                        Cama king size, baño de mármol, vista panorámica y amenidades premium para una estancia íntima y confortable.
                    </p>
                    <ul class="flex flex-wrap gap-2 mb-6">
                        @foreach(['King Size','Baño Privado','WiFi','AC','TV 55"'] as $amenity)
                        <li class="text-[10px] tracking-wide uppercase bg-ivory px-2.5 py-1 text-navy/70 border border-gold/25">{{ $amenity }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ route('habitaciones.index', ['tipo' => 'Matrimonial']) }}"
                       class="block text-center border border-navy hover:bg-navy hover:text-white text-navy text-xs tracking-widest uppercase py-3 transition-all duration-200">
                        Ver Disponibilidad
                    </a>
                </div>
            </div>

            {{-- Doble — highlighted --}}
            <div class="room-card bg-navy reveal" style="transition-delay: 0.1s;">
                <div class="overflow-hidden h-64 relative">
                    <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=800&q=80"
                         alt="Habitación Doble"
                         class="w-full h-full object-cover">
                    <div class="absolute top-4 left-4 bg-gold text-navy-deep text-[10px] tracking-widest uppercase font-semibold px-3 py-1.5">
                        Más Elegida
                    </div>
                </div>
                <div class="p-7">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <p class="text-[10px] tracking-widest uppercase text-gold font-medium mb-1">Habitación</p>
                            <h3 class="font-serif text-white text-2xl font-light">Doble</h3>
                        </div>
                        <div class="text-right">
                            <span class="text-white/40 text-xs">Desde</span>
                            <div class="font-serif text-gold text-2xl font-light">S/ 220</div>
                            <span class="text-white/40 text-[10px]">por noche</span>
                        </div>
                    </div>
                    <p class="text-white/65 text-sm leading-relaxed mb-5">
                        Dos camas dobles o una queen size, perfecta para viajes corporativos o familiares con todas las comodidades modernas.
                    </p>
                    <ul class="flex flex-wrap gap-2 mb-6">
                        @foreach(['2 Camas','Escritorio','WiFi','AC','Minibar'] as $amenity)
                        <li class="text-[10px] tracking-wide uppercase bg-navy-deep px-2.5 py-1 text-white/70 border border-gold/20">{{ $amenity }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ route('habitaciones.index', ['tipo' => 'Doble']) }}"
                       class="block text-center bg-gold hover:bg-gold-dark text-navy-deep text-xs tracking-widest uppercase font-semibold py-3 transition-all duration-200">
                        Ver Disponibilidad
                    </a>
                </div>
            </div>

            {{-- Suite --}}
            <div class="room-card bg-white reveal" style="transition-delay: 0.2s;">
                <div class="overflow-hidden h-64">
                    <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&w=800&q=80"
                         alt="Suite"
                         class="w-full h-full object-cover">
                </div>
                <div class="p-7">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <p class="text-[10px] tracking-widest uppercase text-gold font-medium mb-1">Suite Premium</p>
                            <h3 class="font-serif text-navy text-2xl font-light">Suite</h3>
                        </div>
                        <div class="text-right">
                            <span class="text-navy/40 text-xs">Desde</span>
                            <div class="font-serif text-navy text-2xl font-light">S/ 300</div>
                            <span class="text-navy/40 text-[10px]">por noche</span>
                        </div>
                    </div>
                    <p class="text-navy/60 text-sm leading-relaxed mb-5">
                        La expresión máxima del lujo en Trujillo. Sala independiente, jacuzzi, minibar y servicio de mayordomo las 24 horas.
                    </p>
                    <ul class="flex flex-wrap gap-2 mb-6">
                        @foreach(['Sala Privada','Jacuzzi','Mayordomo','Vista Premium','Desayuno'] as $amenity)
                        <li class="text-[10px] tracking-wide uppercase bg-ivory px-2.5 py-1 text-navy/70 border border-gold/25">{{ $amenity }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ route('habitaciones.index', ['tipo' => 'Suite']) }}"
                       class="block text-center border border-navy hover:bg-navy hover:text-white text-navy text-xs tracking-widest uppercase py-3 transition-all duration-200">
                        Ver Disponibilidad
                    </a>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="text-center mt-12 reveal">
            <a href="{{ route('habitaciones.index') }}"
               class="inline-block text-navy border-b border-gold hover:text-gold text-xs tracking-widest uppercase transition-colors duration-200 pb-0.5">
                Explorar todas las habitaciones <i class="fas fa-arrow-right ml-2 text-[10px]"></i>
            </a>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════
     EXPERIENCES / AMENITIES SECTION
═══════════════════════════════════════════ --}}
<section id="experiencias" class="bg-navy-deep py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="text-center mb-16 reveal">
            <p class="text-gold text-[10px] tracking-widest3 uppercase font-medium mb-3">El Hotel</p>
            <h2 class="font-serif text-white text-4xl sm:text-5xl font-light">Una Experiencia Completa</h2>
            <div class="divider-gold max-w-xs mx-auto mt-5" style="--tw-divide-opacity:0.3">
                <i class="fas fa-diamond text-gold text-[10px]"></i>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-px bg-white/10">
            @foreach([
                ['fa-utensils',       'Restaurante Gourmet',      'Cocina peruana de autor con ingredientes frescos de la región. Abierto desde el desayuno hasta las 23:00.'],
                ['fa-swimming-pool',  'Piscina & Spa',             'Relájese en nuestra piscina climatizada y disfrute de tratamientos corporales de clase mundial.'],
                ['fa-wifi',           'Conectividad Total',        'WiFi de alta velocidad en todas las instalaciones. Business center disponible las 24 horas.'],
                ['fa-concierge-bell', 'Servicio al Huésped',       'Concierge dedicado para reservas, tours por Chan Chan, Huanchaco y el Valle de la Luna.'],
                ['fa-car',            'Traslados & Estacionamiento','Recojo del aeropuerto, valet parking gratuito y flota de vehículos para city tours.'],
                ['fa-glass-cheers',   'Bar & Lounge Rooftop',      'Cócteles exclusivos con vistas panorámicas al skyline de Trujillo. La mejor terraza del norte.'],
            ] as [$icon, $title, $desc])
            <div class="bg-navy p-8 hover:bg-navy-light transition-colors duration-300 reveal">
                <i class="fas {{ $icon }} text-gold text-xl mb-5 block"></i>
                <h3 class="font-serif text-white text-lg font-light mb-3">{{ $title }}</h3>
                <p class="text-white/55 text-sm leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════
     LOCATION SECTION
═══════════════════════════════════════════ --}}
<section id="nosotros" class="bg-ivory-warm py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            {{-- Image collage --}}
            <div class="relative reveal">
                <img src="https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?auto=format&fit=crop&w=800&q=80"
                     alt="DoubleTree Trujillo exterior"
                     class="w-full h-80 lg:h-96 object-cover">
                <div class="absolute -bottom-6 -right-6 w-40 h-40 bg-gold/15 border-4 border-gold/30 hidden lg:block"></div>
                <div class="absolute -top-4 -left-4 w-24 h-24 bg-navy/10 hidden lg:block"></div>
            </div>

            {{-- Copy --}}
            <div class="reveal" style="transition-delay: 0.15s;">
                <p class="text-gold text-[10px] tracking-widest3 uppercase font-medium mb-3">Nuestra Historia</p>
                <h2 class="font-serif text-navy text-3xl sm:text-4xl font-light leading-tight mb-6">
                    En el corazón de<br><em>la ciudad que enamora</em>
                </h2>
                <div class="w-12 h-0.5 bg-gold mb-6"></div>
                <p class="text-navy/65 text-sm leading-relaxed mb-5">
                    Ubicado estratégicamente en Trujillo, el DoubleTree by Hilton es la puerta de entrada
                    a las maravillas del norte peruano. A minutos de Chan Chan, la ciudadela de barro más
                    grande del mundo, y a media hora de las olas de Huanchaco.
                </p>
                <p class="text-navy/65 text-sm leading-relaxed mb-8">
                    Desde nuestra apertura, hemos recibido a viajeros de negocios, familias y parejas que
                    buscan combinar la comodidad del lujo moderno con la riqueza cultural de La Libertad.
                </p>

                <div class="grid grid-cols-2 gap-6 mb-8">
                    @foreach([
                        ['Chan Chan', '8 min', 'fa-landmark'],
                        ['Huanchaco', '25 min', 'fa-umbrella-beach'],
                        ['Aeropuerto', '15 min', 'fa-plane'],
                        ['Centro Histórico', '5 min', 'fa-map-marker-alt'],
                    ] as [$place, $time, $icon])
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gold/15 flex items-center justify-center flex-shrink-0">
                            <i class="fas {{ $icon }} text-gold text-sm"></i>
                        </div>
                        <div>
                            <div class="font-serif text-navy text-sm">{{ $place }}</div>
                            <div class="text-navy/50 text-[11px] tracking-wide">{{ $time }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <a href="{{ route('habitaciones.index') }}"
                   class="inline-block bg-navy hover:bg-navy-deep text-white text-xs tracking-widest uppercase font-medium px-8 py-3.5 transition-all duration-200 hover:shadow-lg">
                    Reservar Ahora
                </a>
            </div>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════
     TESTIMONIALS
═══════════════════════════════════════════ --}}
<section class="bg-white py-20">
    <div class="max-w-5xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-12 reveal">
            <p class="text-gold text-[10px] tracking-widest3 uppercase font-medium mb-3">Nuestros Huéspedes</p>
            <h2 class="font-serif text-navy text-3xl sm:text-4xl font-light">Lo que dicen de nosotros</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['Una experiencia que supera cualquier expectativa. El servicio es impecable y las vistas desde la Suite son inolvidables.', 'María Fernández', 'Lima, Perú', 5],
                ['El mejor hotel en el que he estado durante mis viajes de negocios por el norte. Volveré sin duda.', 'Carlos Rodríguez', 'Bogotá, Colombia', 5],
                ['La habitación Doble es perfecta para familias. Los niños amaron la piscina y nosotros el desayuno gourmet.', 'Ana Gutiérrez', 'Santiago, Chile', 5],
            ] as [$quote, $name, $origin, $stars])
            <div class="testimonial-card pl-6 py-1 reveal">
                <div class="flex text-gold text-xs mb-4 gap-0.5">
                    @for($i = 0; $i < $stars; $i++)
                        <i class="fas fa-star"></i>
                    @endfor
                </div>
                <p class="font-serif text-navy/80 text-base font-light leading-relaxed italic mb-5">
                    "{{ $quote }}"
                </p>
                <div>
                    <div class="font-medium text-navy text-sm">{{ $name }}</div>
                    <div class="text-navy/45 text-xs tracking-wide mt-0.5">{{ $origin }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════
     BOOKING CTA BANNER
═══════════════════════════════════════════ --}}
<section class="bg-gold py-16">
    <div class="max-w-4xl mx-auto px-6 text-center reveal">
        <p class="text-navy-deep/70 text-[10px] tracking-widest3 uppercase mb-3 font-medium">Oferta Exclusiva</p>
        <h2 class="font-serif text-navy-deep text-3xl sm:text-4xl font-light mb-4">
            Reserve Directamente y Obtenga<br><em>el Mejor Precio Garantizado</em>
        </h2>
        <p class="text-navy-deep/70 text-sm mb-8 max-w-lg mx-auto">
            Al reservar en nuestra web oficial evita comisiones intermediarias y accede a beneficios exclusivos para huéspedes directos.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('habitaciones.index') }}"
               class="bg-navy hover:bg-navy-deep text-white text-xs tracking-widest uppercase font-semibold px-10 py-4 transition-all duration-200 hover:shadow-xl w-full sm:w-auto text-center">
                Reservar Ahora
            </a>
            @guest('cliente')
            <a href="{{ route('cliente.registro') }}"
               class="border-2 border-navy-deep text-navy-deep hover:bg-navy-deep hover:text-white text-xs tracking-widest uppercase px-10 py-4 transition-all duration-200 w-full sm:w-auto text-center">
                Crear Cuenta
            </a>
            @endguest
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════ --}}
<footer id="contacto" class="bg-navy-deep text-white/70">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

            {{-- Brand --}}
            <div>
                <div class="mb-5">
                    <p class="font-serif text-white/50 text-xs tracking-widest2 uppercase mb-0.5">DoubleTree by</p>
                    <p class="font-serif text-white text-xl font-light">Hilton Trujillo</p>
                    <p class="text-gold text-[9px] tracking-widest3 uppercase mt-0.5">Hotel & Suites</p>
                </div>
                <p class="text-sm leading-relaxed text-white/50 mb-5">
                    La referencia de hospitalidad de lujo en el norte del Perú desde nuestra apertura.
                </p>
                <div class="flex gap-3">
                    @foreach(['fa-instagram','fa-facebook-f','fa-twitter','fa-tripadvisor'] as $social)
                    <a href="#" class="w-8 h-8 border border-white/20 hover:border-gold flex items-center justify-center text-xs transition-all duration-200">
                        <i class="fab {{ $social }}"></i>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Links --}}
            <div>
                <h4 class="text-white text-[10px] tracking-widest uppercase font-medium mb-5">Navegación</h4>
                <ul class="space-y-2.5 text-sm">
                    @foreach([
                        ['Habitaciones', 'habitaciones.index'],
                        ['Reservar',     'cliente.registro'],
                        ['Mi Cuenta',    'cliente.login'],
                    ] as [$label, $routeName])
                    <li><a href="{{ route($routeName) }}" class="hover:text-gold transition-colors duration-200">{{ $label }}</a></li>
                    @endforeach
                    <li><a href="#experiencias" class="hover:text-gold transition-colors duration-200">Experiencias</a></li>
                    <li><a href="#nosotros"     class="hover:text-gold transition-colors duration-200">El Hotel</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="text-white text-[10px] tracking-widest uppercase font-medium mb-5">Contacto</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2.5">
                        <i class="fas fa-map-marker-alt text-gold text-xs mt-1 flex-shrink-0"></i>
                        <span>Av. El Golf 591, Trujillo 13009<br>La Libertad, Perú</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i class="fas fa-phone text-gold text-xs flex-shrink-0"></i>
                        <a href="tel:+5144123456" class="hover:text-gold transition-colors">(044) 123-456</a>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i class="fas fa-envelope text-gold text-xs flex-shrink-0"></i>
                        <a href="mailto:reservas@doubletreetrujillo.com" class="hover:text-gold transition-colors text-xs">reservas@doubletreetrujillo.com</a>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i class="fas fa-clock text-gold text-xs flex-shrink-0"></i>
                        <span>Recepción 24 horas</span>
                    </li>
                </ul>
            </div>

            {{-- Newsletter --}}
            <div>
                <h4 class="text-white text-[10px] tracking-widest uppercase font-medium mb-5">Ofertas Exclusivas</h4>
                <p class="text-sm text-white/50 mb-4">Suscríbase para recibir tarifas especiales y novedades del hotel.</p>
                <form class="flex flex-col gap-2" onsubmit="return false;">
                    <input type="email" placeholder="correo@ejemplo.com"
                           class="bg-white/10 border border-white/20 focus:border-gold text-white text-sm px-3 py-2.5 outline-none transition-colors duration-200 placeholder:text-white/30">
                    <button type="button"
                            class="bg-gold hover:bg-gold-dark text-navy-deep text-[10px] tracking-widest uppercase font-semibold py-2.5 transition-all duration-200">
                        Suscribirse
                    </button>
                </form>
            </div>

        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-white/10 mt-12 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-white/35">
            <span>© {{ date('Y') }} DoubleTree by Hilton Trujillo. Todos los derechos reservados.</span>
            <div class="flex items-center gap-4">
                <a href="#" class="hover:text-gold transition-colors">Política de Privacidad</a>
                <span>·</span>
                <a href="#" class="hover:text-gold transition-colors">Términos de Uso</a>
                <span>·</span>
                <div class="flex items-center gap-1.5">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png"
                         alt="Visa" class="h-4 opacity-40">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg"
                         alt="Mastercard" class="h-4 opacity-40">
                </div>
            </div>
        </div>
    </div>
</footer>


{{-- ═══════════════════════════════════════════
     SCRIPTS
═══════════════════════════════════════════ --}}
<script>
/* ── Navbar scroll effect ── */
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    if (window.scrollY > 80) {
        navbar.classList.remove('nav-transparent');
        navbar.classList.add('nav-solid');
    } else {
        navbar.classList.add('nav-transparent');
        navbar.classList.remove('nav-solid');
    }
}, { passive: true });

/* ── Mobile menu ── */
document.getElementById('mobileMenuBtn').addEventListener('click', () => {
    document.getElementById('mobileMenu').classList.toggle('hidden');
});

/* ── Scroll reveal ── */
const revealEls = document.querySelectorAll('.reveal');
const observer = new IntersectionObserver((entries) => {
    entries.forEach(el => {
        if (el.isIntersecting) {
            el.target.classList.add('visible');
            observer.unobserve(el.target);
        }
    });
}, { threshold: 0.12, rootMargin: '0px 0px -50px 0px' });
revealEls.forEach(el => observer.observe(el));

/* ── Checkout date auto-advance when checkin changes ── */
const checkinInput  = document.querySelector('input[name="checkin"]');
const checkoutInput = document.querySelector('input[name="checkout"]');
if (checkinInput && checkoutInput) {
    checkinInput.addEventListener('change', () => {
        const nextDay = new Date(checkinInput.value);
        nextDay.setDate(nextDay.getDate() + 1);
        const fmt = nextDay.toISOString().split('T')[0];
        checkoutInput.min   = fmt;
        if (checkoutInput.value <= checkinInput.value) checkoutInput.value = fmt;
    });
}
</script>

</body>
</html>